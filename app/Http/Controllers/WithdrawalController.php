<?php

namespace App\Http\Controllers;

use AbcAeffchen\SepaUtilities\SepaUtilities;
use AbcAeffchen\Sephpa\SephpaDirectDebit;
use AbcAeffchen\Sephpa\SephpaInputException;
use App\Mail\OmnomcomFailedWithdrawalNotification;
use App\Mail\OmnomcomWithdrawalNotification;
use App\Models\Account;
use App\Models\FailedWithdrawal;
use App\Models\OrderLine;
use App\Models\Product;
use App\Models\User;
use App\Models\Withdrawal;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class WithdrawalController extends Controller
{
    public function index(): View
    {
        $withdrawals = Withdrawal::query()
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('omnomcom.withdrawals.index', ['withdrawals' => $withdrawals]);
    }

    public function create(): View
    {
        return view('omnomcom.withdrawals.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'date' => 'required|date',
            'max' => 'required|numeric|min:1',
        ]);

        $max = $request->integer('max');

        $date = $request->date('date')->format('Y-m-d');

        $withdrawal = Withdrawal::query()->create([
            'date' => $date,
        ]);

        $totalPerUser = [];

        $orderlines = OrderLine::unpayed()->whereHas('user')->with('product', 'product.ticket')->get();
        foreach ($orderlines as $orderline) {
            if (! array_key_exists($orderline->user->id, $totalPerUser)) {
                $totalPerUser[$orderline->user->id] = 0;
            }

            if ($max != null && $max < $totalPerUser[$orderline->user->id] + $orderline->total_price) {
                continue;
            }

            // only add the tickets to the withdrawal if the ticket can not be bought anymore
            if ($orderline->product->ticket && Carbon::now()->timestamp <= $orderline->product->ticket->available_to) {
                continue;
            }

            $orderline->withdrawal()->associate($withdrawal);
            $orderline->save();

            $totalPerUser[$orderline->user->id] += $orderline->total_price;
        }

        foreach ($totalPerUser as $user_id => $total) {
            if ($total < 0) {
                $user = User::query()->findOrFail($user_id);
                $orderlinesFor = $withdrawal->orderlinesForUser($user);
                foreach ($orderlinesFor as $orderlineFor) {
                    $orderlineFor->withdrawal()->dissociate();
                    $orderlineFor->save();
                }
            }
        }

        $withdrawal->recalculateTotals();

        return Redirect::route('omnomcom::withdrawal::show', ['id' => $withdrawal->id]);
    }

    public function show(int $id): View
    {
        $withdrawal = Withdrawal::query()
            ->withCount(['orderlines', 'users'])
            ->with('failedWithdrawals', function ($q) {
                $q->where('user_id', Auth::user()->id);
            })
            ->findOrFail($id);

        $userLines = OrderLine::query()
            ->selectRaw('user_id, count(id) as orderline_count, sum(total_price) as total_price')
            ->where('payed_with_withdrawal', $id)
            ->groupBy('user_id')
            ->with('user.bank')
            ->get();

        return view('omnomcom.withdrawals.show', ['withdrawal' => $withdrawal, 'userLines' => $userLines]);
    }

    public function showAccounts(int $id): View
    {
        /** @var Withdrawal $withdrawal */
        $withdrawal = Withdrawal::query()->findOrFail($id);

        // generate a list of all the accounts and their total orderlines for the given month
        // grouped by account number and then by orderline date
        // this is used to generate a table with the total orderlines for each account, and product
        $accounts = Account::query()->join('products', 'accounts.id', '=', 'products.account_id')
            ->join('orderlines', 'products.id', '=', 'orderlines.product_id')
            ->where('orderlines.payed_with_withdrawal', $withdrawal->id)
            ->groupByRaw('DATE(DATE_ADD(orderlines.created_at, INTERVAL -6 HOUR))')
            ->groupBy('orderlines.product_id')
            ->selectRaw('accounts.account_number, accounts.name as account_name, DATE(orderlines.created_at) as orderline_date, products.name as product_name,  SUM(orderlines.total_price) as total')
            ->get()->groupBy('account_number')->sortByDesc('account_number')->map(fn ($account) => $account->groupBy('orderline_date'));

        return view('omnomcom.accounts.orderlines-breakdown', [
            'accounts' => $accounts,
            'title' => 'Accounts of withdrawal of '.Carbon::parse($withdrawal->date)->format('d-m-Y'),
            'total' => $withdrawal->total(),
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        /** @var Withdrawal $withdrawal */
        $withdrawal = Withdrawal::query()->findOrFail($id);

        $request->validate([
            'date' => 'required|date',
            'max' => 'required|numeric|min:1',
        ]);
        if ($withdrawal->closed) {
            Session::flash('flash_message', 'This withdrawal is already closed and cannot be edited.');

            return Redirect::back();
        }

        $withdrawal->date = $request->date('date')->format('Y-m-d');
        $withdrawal->save();

        Session::flash('flash_message', 'Withdrawal updated.');

        return Redirect::route('omnomcom::withdrawal::show', ['id' => $withdrawal->id]);
    }

    /**
     * @throws Exception
     */
    public function destroy(int $id): RedirectResponse
    {
        /** @var Withdrawal $withdrawal */
        $withdrawal = Withdrawal::query()->findOrFail($id);

        if ($withdrawal->closed) {
            Session::flash('flash_message', 'This withdrawal is already closed and cannot be deleted.');

            return Redirect::back();
        }

        foreach ($withdrawal->orderlines as $orderline) {
            $orderline->withdrawal()->dissociate();
            $orderline->save();
        }

        foreach (FailedWithdrawal::query()->where('withdrawal_id', $withdrawal->id)->get() as $failed_withdrawal) {
            /** @var FailedWithdrawal $failed_withdrawal */
            $failed_withdrawal->correctionOrderline->delete();
            $failed_withdrawal->delete();
        }

        $withdrawal->delete();

        Session::flash('flash_message', 'Withdrawal deleted.');

        return Redirect::route('omnomcom::withdrawal::index');
    }

    public static function deleteFrom(int $id, int $user_id): RedirectResponse
    {
        /** @var Withdrawal $withdrawal */
        $withdrawal = Withdrawal::query()->findOrFail($id);

        if ($withdrawal->closed) {
            Session::flash('flash_message', 'This withdrawal is already closed and cannot be edited.');

            return Redirect::back();
        }

        /** @var User $user */
        $user = User::withTrashed()->findOrFail($user_id);

        foreach ($withdrawal->orderlinesForUser($user) as $orderline) {
            $orderline->withdrawal()->dissociate();
            $orderline->save();
        }

        $withdrawal->recalculateTotals();

        Session::flash('flash_message', "Orderlines for $user->name removed from this withdrawal.");

        return Redirect::back();
    }

    public static function markFailed(Request $request, int $id, int $user_id): RedirectResponse
    {
        /** @var Withdrawal $withdrawal */
        $withdrawal = Withdrawal::query()->findOrFail($id);

        if ($withdrawal->closed) {
            Session::flash('flash_message', 'This withdrawal is already closed and cannot be edited.');

            return Redirect::back();
        }

        /** @var User $user */
        $user = User::query()->findOrFail($user_id);

        if (FailedWithdrawal::query()->where('user_id', $user_id)->where('withdrawal_id', $id)->first() !== null) {
            Session::flash('flash_message', 'This withdrawal has already been marked as failed.');

            return Redirect::back();
        }

        /** @var Product $product */
        $product = Product::query()->findOrFail(Config::integer('omnomcom.failed-withdrawal'));
        $total = $withdrawal->totalForUser($user);

        /** @var OrderLine $failedOrderline */
        $failedOrderline = OrderLine::query()->findOrFail($product->buyForUser(
            $user,
            1,
            $total,
            null,
            null,
            sprintf('Overdue payment due to the failed withdrawal from %s.', Carbon::parse($withdrawal->date)->format('d-m-Y')),
            sprintf('failed_withdrawal_by_%u', Auth::user()->id)
        ));

        FailedWithdrawal::query()->create([
            'user_id' => $user->id,
            'withdrawal_id' => $withdrawal->id,
            'correction_orderline_id' => $failedOrderline->id,
        ])->save();

        Mail::to($user)->queue((new OmnomcomFailedWithdrawalNotification($user, $withdrawal))->onQueue('medium'));

        Session::flash('flash_message', "Withdrawal for $user->name marked as failed. User e-mailed.");

        return Redirect::back();
    }

    /**
     * @return RedirectResponse
     */
    public static function markLoss(int $id, int $user_id)
    {
        /** @var Withdrawal $withdrawal */
        $withdrawal = Withdrawal::query()->findOrFail($id);

        if ($withdrawal->closed) {
            Session::flash('flash_message', 'This withdrawal is already closed and cannot be edited.');

            return Redirect::back();
        }

        /** @var User $user */
        $user = User::query()->findOrFail($user_id);

        $orderlines = $withdrawal->orderlinesForUser($user);

        foreach ($orderlines as $orderline) {
            $orderline->withdrawal()->dissociate();
            $orderline->payed_with_loss = true;
            $orderline->save();
        }

        $withdrawal->recalculateTotals();

        Session::flash('flash_message', "Withdrawal for $user->name marked as loss.");

        return Redirect::back();
    }

    public static function export(int $id): RedirectResponse|\Illuminate\Http\Response
    {
        /** @var Withdrawal $withdrawal */
        $withdrawal = Withdrawal::query()->findOrFail($id);

        if (! $withdrawal->orderlines()->exists()) {
            Session::flash('flash_message', 'Cannot export! This withdrawal is empty.');

            return Redirect::back();
        }

        if ($withdrawal->users()->whereDoesntHave('bank')->exists()) {
            Session::flash('flash_message', 'Cannot export! A user in this withdrawal is missing bank information.');

            return Redirect::back();
        }

        $debitCollectionData = [
            'pmtInfId' => sprintf('%s-1', $withdrawal->withdrawalId),
            'lclInstrm' => SepaUtilities::LOCAL_INSTRUMENT_CORE_DIRECT_DEBIT,
            'seqTp' => SepaUtilities::SEQUENCE_TYPE_FIRST,
            'cdtr' => 'Study Association Proto',
            'iban' => Config::string('proto.sepa_info.iban'),
            'bic' => Config::string('proto.sepa_info.bic'),
            'ci' => Config::string('proto.sepa_info.creditor_id'),
            'ccy' => 'EUR',
            'ultmtCdtr' => 'S.A. Proto',
            'reqdColltnDt' => $withdrawal->date,
        ];
        try {
            $directDebit = new SephpaDirectDebit('Study Association Proto', $withdrawal->withdrawalId, SephpaDirectDebit::SEPA_PAIN_008_001_02);
            $collection = $directDebit->addCollection($debitCollectionData);
        } catch (SephpaInputException $sephpaInputException) {
            Session::flash('flash_message', "Error creating the withdrawal. Error: {$sephpaInputException->getMessage()}");

            return Redirect::back();
        }

        $i = 1;
        $userQuery = User::query()->select(['id', 'name'])->without(['roles', 'member', 'photo'])->whereHas('orderlines', function ($q) use ($withdrawal) {
            $q->where('payed_with_withdrawal', $withdrawal->id);
        })->withSum(['orderlines as orderlines_total' => function ($q) use ($withdrawal) {
            $q->where('payed_with_withdrawal', $withdrawal->id);
        }], 'total_price')->with('bank:user_id,machtigingid,iban,bic,created_at');

        foreach ($userQuery->get()->each->setAppends([]) as $user) {
            /** @var User $user */
            try {
                $collection->addPayment([
                    'pmtId' => sprintf('%s-1-%s', $withdrawal->withdrawalId, $i),
                    /** @phpstan-ignore-next-line */
                    'instdAmt' => number_format($user->orderlines_total, 2, '.', ''),
                    'mndtId' => $user->bank->machtigingid,
                    'dtOfSgntr' => Carbon::parse($user->bank->created_at)->format('Y-m-d'),
                    'bic' => $user->bank->bic,
                    'dbtr' => $user->name,
                    'iban' => $user->bank->iban,
                ]);
                $i++;

                /** @phpstan-ignore-next-line */
            } catch (SephpaInputException $e) {
                Session::flash('flash_message', "Error creating the withdrawal. user {$user->id}: Error: {$e->getMessage()}");

                return Redirect::back();
            }
        }

        try {
            $response = $directDebit->generateOutput()[0];
        } catch (Exception $exception) {
            Session::flash('flash_message', "Error creating the xml file. Error: {$exception->getMessage()}");

            return Redirect::back();
        }

        $headers = [
            'Content-Encoding' => 'UTF-8',
            'Content-Type' => 'text/xml; charset=UTF-8',
            'Content-Disposition' => sprintf('attachment; filename="%s"', $response['name']),
        ];

        Session::flash('flash_message', 'The withdrawal has been exported. Still check if the total is correct!');

        return Response::make($response['data'], 200, $headers);
    }

    public static function close(int $id): RedirectResponse
    {
        /** @var Withdrawal $withdrawal */
        $withdrawal = Withdrawal::query()->findOrFail($id);

        if ($withdrawal->closed) {
            Session::flash('flash_message', 'This withdrawal is already closed and cannot be edited.');

            return Redirect::back();
        }

        $withdrawal->closed = true;
        $withdrawal->save();

        Session::flash('flash_message', 'The withdrawal is now closed. Changes cannot be made anymore.');

        return Redirect::back();
    }

    public function showForUser(int $id): View
    {
        /** @var Withdrawal $withdrawal */
        $withdrawal = Withdrawal::query()
            ->with([
                'orderlines.product',
            ])->findOrFail($id);

        return view('omnomcom.withdrawals.userhistory', ['withdrawal' => $withdrawal, 'orderlines' => $withdrawal->orderlinesForUser(Auth::user())]);
    }

    /**
     * Send an e-mail to all users in the withdrawal to notice them.
     */
    public function email(int $id): RedirectResponse
    {
        /** @var Withdrawal $withdrawal */
        $withdrawal = Withdrawal::query()->findOrFail($id);

        if ($withdrawal->closed) {
            Session::flash('flash_message', 'This withdrawal is already closed so e-mails cannot be sent.');

            return Redirect::back();
        }

        foreach ($withdrawal->users()->get() as $user) {
            Mail::to($user)->queue((new OmnomcomWithdrawalNotification($user, $withdrawal))->onQueue('medium'));
        }

        Session::flash('flash_message', 'All e-mails have been queued.');

        return Redirect::back();
    }

    public function unwithdrawable(): View
    {
        $users = User::query()->whereHas('orderlines', function ($q) {
            $q->unpayed();
        })->whereDoesntHave('bank')
            ->with('orderlines', function ($q) {
                $q->unpayed()->with('product');
            })
            ->withTrashed()
            ->get();

        return view('omnomcom.unwithdrawable', ['users' => $users]);
    }

    public static function openOrderlinesSum(): int|float
    {
        return OrderLine::query()->unpayed()->sum('total_price');
    }

    public static function openOrderlinesTotal(): int
    {
        return OrderLine::query()->unpayed()->count();
    }
}
