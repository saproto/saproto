<?php

namespace Proto\Http\Controllers;

use AbcAeffchen\SepaUtilities\SepaUtilities;
use AbcAeffchen\Sephpa\SephpaDirectDebit;
use AbcAeffchen\Sephpa\SephpaInputException;
use Auth;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Mail;
use Proto\Mail\OmnomcomFailedWithdrawalNotification;
use Proto\Mail\OmnomcomWithdrawalNotification;
use Proto\Models\Account;
use Proto\Models\FailedWithdrawal;
use Proto\Models\OrderLine;
use Proto\Models\Product;
use Proto\Models\User;
use Proto\Models\Withdrawal;
use Redirect;
use Response;

class WithdrawalController extends Controller
{
    public function index(): View
    {
        return view('omnomcom.withdrawals.index', ['withdrawals' => Withdrawal::orderBy('id', 'desc')->paginate(6)]);
    }

    public function create(): View
    {
        return view('omnomcom.withdrawals.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $max = ($request->has('max') ? $request->input('max') : null);
        if ($max < 0) {
            $max = null;
        }

        $date = strtotime($request->input('date'));
        if ($date === false) {
            Session::flash('flash_message', 'Invalid date.');

            return Redirect::back();
        }

        $withdrawal = Withdrawal::create([
            'date' => date('Y-m-d', $date),
        ]);

        $totalPerUser = [];
        foreach (OrderLine::whereNull('payed_with_withdrawal')->with('product', 'product.ticket')->get() as $orderline) {
            if ($orderline->isPayed()) {
                continue;
            }

            if ($orderline->user === null) {
                continue;
            }

            if (! array_key_exists($orderline->user->id, $totalPerUser)) {
                $totalPerUser[$orderline->user->id] = 0;
            }

            if ($max != null) {
                if ($totalPerUser[$orderline->user->id] + $orderline->total_price > $max) {
                    continue;
                }
            }

            //only add the tickets to the withdrawal if the ticket can not be bought anymore
            if ($orderline->product->ticket && Carbon::now()->timestamp <= $orderline->product->ticket->available_to) {
                continue;
            }

            $orderline->withdrawal()->associate($withdrawal);
            $orderline->save();

            $totalPerUser[$orderline->user->id] += $orderline->total_price;
        }

        foreach ($totalPerUser as $user_id => $total) {
            if ($total < 0) {
                /** @var User $user */
                $user = User::findOrFail($user_id);
                foreach ($withdrawal->orderlinesForUser($user) as $orderline) {
                    $orderline->withdrawal()->dissociate();
                    $orderline->save();
                }
            }
        }

        return Redirect::route('omnomcom::withdrawal::show', ['id' => $withdrawal->id]);
    }

    public function show(int $id): View
    {
        return view('omnomcom.withdrawals.show', ['withdrawal' => Withdrawal::findOrFail($id)]);
    }

    public function showAccounts(int $id): View
    {
        $withdrawal = Withdrawal::findOrFail($id);

        // We do one massive query to reduce the number of queries.
        $orderlines = DB::table('orderlines')
            ->join('products', 'orderlines.product_id', '=', 'products.id')
            ->join('accounts', 'products.account_id', '=', 'accounts.id')
            ->select('orderlines.*', 'accounts.account_number', 'accounts.name')
            ->where('orderlines.payed_with_withdrawal', $withdrawal->id)
            ->get();

        return view('omnomcom.accounts.orderlines-breakdown', [
            'accounts' => Account::generateAccountOverviewFromOrderlines($orderlines),
            'title' => 'Accounts of withdrawal of '.date('d-m-Y', strtotime($withdrawal->date)),
            'total' => $withdrawal->total(),
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        /** @var Withdrawal $withdrawal */
        $withdrawal = Withdrawal::findOrFail($id);

        if ($withdrawal->closed) {
            Session::flash('flash_message', 'This withdrawal is already closed and cannot be edited.');

            return Redirect::back();
        }

        $date = strtotime($request->input('date'));
        if ($date === false) {
            Session::flash('flash_message', 'Invalid date.');

            return Redirect::back();
        }

        $withdrawal->date = date('Y-m-d', $date);
        $withdrawal->save();

        Session::flash('flash_message', 'Withdrawal updated.');

        return Redirect::route('omnomcom::withdrawal::show', ['id' => $withdrawal->id]);
    }

    /**
     * @throws Exception
     */
    public function destroy(Request $request, int $id): RedirectResponse
    {
        $withdrawal = Withdrawal::findOrFail($id);

        if ($withdrawal->closed) {
            Session::flash('flash_message', 'This withdrawal is already closed and cannot be deleted.');

            return Redirect::back();
        }

        foreach ($withdrawal->orderlines as $orderline) {
            $orderline->withdrawal()->dissociate();
            $orderline->save();
        }

        foreach (FailedWithdrawal::where('withdrawal_id', $withdrawal->id)->get() as $failed_withdrawal) {
            $failed_withdrawal->correction_orderline->delete();
            $failed_withdrawal->delete();
        }

        $withdrawal->delete();

        Session::flash('flash_message', 'Withdrawal deleted.');

        return Redirect::route('omnomcom::withdrawal::list');
    }

    /**
     * @param  int[]  $userIds
     */
    public static function dSeleteFrom(Withdrawal $withdrawal, array $userIds): RedirectResponse
    {
        $names = '';
        foreach ($userIds as $user_id) {
            /** @var User $user */
            $user = User::withTrashed()->find($user_id);

            foreach ($withdrawal->orderlinesForUser($user) as $orderline) {
                $orderline->withdrawal()->dissociate();
                $orderline->save();
            }

            $names .= $user->name.', ';
        }

        Session::flash('flash_message', "Orderlines for $names removed from this withdrawal.");

        return Redirect::back();
    }

    /**
     * @param  int[]  $userIds
     */
    public static function markFailed(Withdrawal $withdrawal, array $userIds): RedirectResponse
    {
        $names = '';
        foreach ($userIds as $user_id) {
            /** @var User $user */
            $user = User::find($user_id);

            if (FailedWithdrawal::where('user_id', $user_id)->where('withdrawal_id', $withdrawal->id)->first() !== null) {
                continue;
            }

            /** @var Product $product */
            $product = Product::findOrFail(config('omnomcom.failed-withdrawal'));
            $total = $withdrawal->totalForUser($user);

            /** @var OrderLine $failedOrderline */
            $failedOrderline = OrderLine::findOrFail(
                $product->buyForUser(
                    $user,
                    1,
                    $total,
                    null,
                    null,
                    sprintf('Overdue payment due to the failed withdrawal from %s.', date('d-m-Y', strtotime($withdrawal->date))),
                    sprintf('failed_withdrawal_by_%u', Auth::user()->id)
                )
            );

            FailedWithdrawal::create([
                'user_id' => $user->id,
                'withdrawal_id' => $withdrawal->id,
                'correction_orderline_id' => $failedOrderline->id,
            ])->save();

            Mail::to($user)->queue((new OmnomcomFailedWithdrawalNotification($user, $withdrawal))->onQueue('medium'));
            $names .= $user->name.', ';
        }

        Session::flash('flash_message', "Withdrawal for $names marked as failed. Users e-mailed.");

        return Redirect::back();
    }

    /**
     * @return RedirectResponse|void
     */
    public function bulkUpdate(Request $request, int $id)
    {
        /** @var Withdrawal $withdrawal */
        $withdrawal = Withdrawal::findOrFail($id);

        if ($withdrawal->closed) {
            Session::flash('flash_message', 'This withdrawal is already closed and cannot be edited.');

            return Redirect::back();
        }

        $action = $request->input('action');
        $userIds = $request->input('markids');
        if (! $action) {
            Session::flash('flash_message', 'No action given, please use one of the action buttons');

            return Redirect::back();
        }
        if (! $userIds || count($userIds) <= 0) {
            Session::flash('flash_message', 'No users given to perform the action on!');

            return Redirect::back();
        }

        if ($action === 'markfailed') {
            return $this->markFailed($withdrawal, $userIds);
        } elseif ($action === 'remove') {
            return $this->deleteFrom($withdrawal, $userIds);
        } else {
            Session::flash('flash_message', 'The inputted action is not recognised, please try again');

            return Redirect::back();
        }
    }

    public static function markLoss(Request $request, int $id, int $user_id): RedirectResponse
    {
        /** @var Withdrawal $withdrawal */
        $withdrawal = Withdrawal::findOrFail($id);

        if ($withdrawal->closed) {
            Session::flash('flash_message', 'This withdrawal is already closed and cannot be edited.');

            return Redirect::back();
        }

        /** @var User $user */
        $user = User::findOrFail($user_id);

        /** @var Orderline[] $orderlines */
        $orderlines = $withdrawal->orderlinesForUser($user);

        foreach ($orderlines as $orderline) {
            $orderline->withdrawal()->dissociate();
            $orderline->payed_with_loss = true;
            $orderline->save();
        }

        Session::flash('flash_message', "Withdrawal for $user->name marked as loss.");

        return Redirect::back();
    }

    /**
     * @return RedirectResponse|\Illuminate\Http\Response
     *
     * @throws SephpaInputException
     */
    public static function export(Request $request, int $id)
    {
        /** @var Withdrawal $withdrawal */
        $withdrawal = Withdrawal::findOrFail($id);

        if ($withdrawal->orderlines()->count() == 0) {
            Session::flash('flash_message', 'Cannot export! This withdrawal is empty.');

            return Redirect::back();
        }

        foreach ($withdrawal->users() as $user) {
            if (! isset($user->bank)) {
                Session::flash('flash_message', 'Cannot export! A user in this withdrawal is missing bank information.');

                return Redirect::back();
            }
        }

        $direct_debit = new SephpaDirectDebit('Study Association Proto', $withdrawal->withdrawalId(), SephpaDirectDebit::SEPA_PAIN_008_001_02, [
            'pmtInfId' => sprintf('%s-1', $withdrawal->withdrawalId()),
            'lclInstrm' => SepaUtilities::LOCAL_INSTRUMENT_CORE_DIRECT_DEBIT,
            'seqTp' => SepaUtilities::SEQUENCE_TYPE_FIRST,
            'cdtr' => 'Study Association Proto',
            'iban' => config('proto.sepa_info')->iban,
            'bic' => config('proto.sepa_info')->bic,
            'ci' => config('proto.sepa_info')->creditor_id,
            'ccy' => 'EUR',
            'ultmtCdtr' => 'S.A. Proto',
            'reqdColltnDt' => $withdrawal->date,
        ]);

        $i = 1;
        foreach ($withdrawal->users() as $user) {
            try {
                $direct_debit->addPayment([
                    'pmtId' => sprintf('%s-1-%s', $withdrawal->withdrawalId(), $i),
                    'instdAmt' => number_format($withdrawal->totalForUser($user), 2, '.', ''),
                    'mndtId' => $user->bank->machtigingid,
                    'dtOfSgntr' => date('Y-m-d', strtotime($user->bank->created_at)),
                    'bic' => $user->bank->bic,
                    'dbtr' => $user->name,
                    'iban' => $user->bank->iban,
                ]);
                $i++;
            } catch (SephpaInputException $e) {
                abort(500, sprintf('Error for user #%s: %s', $user->id, $e->getMessage()));
            }
        }

        $response = $direct_debit->generateOutput([], false)[0];

        $headers = [
            'Content-Encoding' => 'UTF-8',
            'Content-Type' => 'text/xml; charset=UTF-8',
            'Content-Disposition' => sprintf('attachment; filename="%s"', $response['name']),
        ];

        return Response::make($response['data'], 200, $headers);
    }

    /**
     * @param  int  $id
     * @return RedirectResponse
     */
    public static function close(Request $request, $id)
    {
        /** @var Withdrawal $withdrawal */
        $withdrawal = Withdrawal::findOrFail($id);

        if ($withdrawal->closed) {
            Session::flash('flash_message', 'This withdrawal is already closed and cannot be edited.');

            return Redirect::back();
        }

        $withdrawal->closed = true;
        $withdrawal->save();

        Session::flash('flash_message', 'The withdrawal is now closed. Changes cannot be made anymore.');

        return Redirect::back();
    }

    public function showForUser(Request $request, int $id): View
    {
        $withdrawal = Withdrawal::findOrFail($id);

        return view('omnomcom.withdrawals.userhistory', ['withdrawal' => $withdrawal, 'orderlines' => $withdrawal->orderlinesForUser(Auth::user())]);
    }

    /**
     * Send an e-mail to all users in the withdrawal to notice them.
     */
    public function email(Request $request, int $id): RedirectResponse
    {
        /** @var Withdrawal $withdrawal */
        $withdrawal = Withdrawal::findOrFail($id);

        if ($withdrawal->closed) {
            Session::flash('flash_message', 'This withdrawal is already closed so e-mails cannot be sent.');

            return Redirect::back();
        }

        foreach ($withdrawal->users() as $user) {
            Mail::to($user)->queue((new OmnomcomWithdrawalNotification($user, $withdrawal))->onQueue('medium'));
        }

        Session::flash('flash_message', 'All e-mails have been queued.');

        return Redirect::back();
    }

    public function unwithdrawable(): View
    {
        $users = [];

        /** @var OrderLine $orderline */
        foreach (OrderLine::whereNull('payed_with_withdrawal')->get() as $orderline) {
            if ($orderline->isPayed()) {
                continue;
            }

            if ($orderline->user === null) {
                Session::flash('flash_message', 'There are unpaid anonymous orderlines. Please contact the IT committee.');

                continue;
            }
            if ($orderline->user->bank) {
                continue;
            }
            if (! in_array($orderline->user->id, array_keys($users))) {
                $users[$orderline->user->id] = (object) [
                    'user' => $orderline->user,
                    'orderlines' => [],
                    'total' => 0,
                ];
            }

            $users[$orderline->user->id]->orderlines[] = $orderline;
            $users[$orderline->user->id]->total += $orderline->total_price;
        }

        return view('omnomcom.unwithdrawable', ['users' => $users]);
    }

    /** @return float|int */
    public static function openOrderlinesSum(): int
    {
        $sum = 0;
        foreach (OrderLine::whereNull('payed_with_withdrawal')->get() as $orderline) {
            if ($orderline->isPayed()) {
                continue;
            }
            $sum += $orderline->total_price;
        }

        return $sum;
    }

    public static function openOrderlinesTotal(): int
    {
        $total = 0;
        foreach (OrderLine::whereNull('payed_with_withdrawal')->get() as $orderline) {
            if ($orderline->isPayed()) {
                continue;
            }
            $total++;
        }

        return $total;
    }
}
