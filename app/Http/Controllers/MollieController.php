<?php

namespace App\Http\Controllers;

use App\Enums\MollieEnum;
use App\Models\Account;
use App\Models\Event;
use App\Models\MollieTransaction;
use App\Models\OrderLine;
use App\Models\User;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Mollie;
use Mollie\Api\Exceptions\ApiException;

class MollieController extends Controller
{
    /**
     * @return View
     */
    public function index(Request $request): \Illuminate\Contracts\View\View|Factory
    {
        $user = $request->input('user_id') ? User::query()->findOrFail($request->input('user_id')) : null;

        $transactions = MollieTransaction::query()
            ->when($user, static fn ($query, $user) => $query->where('user_id', $user->id))
            ->latest()
            ->with('user')
            ->paginate(15);

        return view('omnomcom.mollie.list', ['user' => $user, 'transactions' => $transactions]);
    }

    /**
     * @throws ApiException
     */
    public function pay(Request $request): RedirectResponse
    {
        $cap = intval($request->input('cap'));
        $total = 0;

        $orderlines = [];
        $unpaid_orderlines = OrderLine::query()
            ->where('user_id', Auth::id())
            ->unprocessed()
            ->orderBy('total_price')
            ->orderBy('created_at', 'desc')
            ->get();

        if ($unpaid_orderlines->min('total_price') > $cap) {
            Session::flash(
                'flash_message',
                'You cannot complete a purchase using this cap. Please try to increase the maximum amount you wish to pay!'
            );

            return back();
        }

        foreach ($unpaid_orderlines as $orderline) {
            if ($total + $orderline->total_price <= $cap) {
                $orderlines[] = $orderline->id;
                $total += $orderline->total_price;
            } else {
                break;
            }
        }

        $transaction = self::createPaymentForOrderlines($orderlines);

        return Redirect::away($transaction->payment_url);
    }

    /**
     * @return View
     *
     * @throws Exception
     */
    public function status(int $id): \Illuminate\Contracts\View\View|Factory
    {
        /** @var MollieTransaction $transaction */
        $transaction = MollieTransaction::query()->findOrFail($id);
        abort_if($transaction->user->id != Auth::id() && ! Auth::user()->can('board'), 403, 'You are unauthorized to view this transaction.');

        $transaction = $transaction->updateFromWebhook();

        return view('omnomcom.mollie.status', [
            'transaction' => $transaction,
            'mollie' => Mollie::api()
                ->payments
                ->get($transaction->mollie_id),
        ]);
    }

    /**
     * @return View|RedirectResponse
     */
    public function monthly(string $month): RedirectResponse|Factory|\Illuminate\Contracts\View\View
    {
        try {
            $month = Date::parse($month);
        } catch (Exception) {
            Session::flash('flash_message', 'Invalid date: '.$month);

            return back();
        }

        $start = $month->copy()->startOfMonth();
        if ($start->isWeekend()) {
            $start->nextWeekday();
        }

        $end = $month->copy()->addMonth()->startOfMonth();
        if ($end->isWeekend()) {
            $end->nextWeekday();
        }

        // generate a list of all the accounts and their total orderlines for the given month
        // grouped by account number and then by orderline date
        // this is used to generate a table with the total orderlines for each account, and product
        $accounts = Account::query()->join('products', 'accounts.id', '=', 'products.account_id')
            ->join('orderlines', 'products.id', '=', 'orderlines.product_id')
            ->join('mollie_transactions', 'orderlines.payed_with_mollie', '=', 'mollie_transactions.id')
            ->selectRaw('DATE(DATE_ADD(mollie_transactions.created_at, INTERVAL -6 HOUR)) as orderline_date')
            ->whereRaw('DATE(DATE_ADD(mollie_transactions.created_at, INTERVAL -6 HOUR)) BETWEEN ? AND ?', [$start, $end])
            ->whereIn('mollie_transactions.status', Config::array('omnomcom.mollie.paid_statuses'))
            ->groupByRaw('orderline_date')
            ->selectRaw('accounts.account_number, accounts.name as account_name, SUM(orderlines.total_price) as total')
            ->get()->groupBy('account_number')->sortByDesc('account_number')->map(fn ($account) => $account->groupBy('orderline_date'));

        return view('omnomcom.accounts.orderlines-breakdown', [
            'accounts' => $accounts,
            'title' => 'Account breakdown for Mollie transactions between '.$start->format('d-m-Y').' and '.$end->format('d-m-Y'),
        ]);
    }

    /**
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function receive(int $id)
    {
        /** @var MollieTransaction $transaction */
        $transaction = MollieTransaction::query()->findOrFail($id);
        $flash_message = '';
        if ($transaction->user_id == Auth::id()) {
            switch (MollieTransaction::translateStatus($transaction->status)) {
                case MollieEnum::FAILED:
                    $flash_message = 'Your payment has failed';
                    break;
                case MollieEnum::OPEN:
                    $flash_message = 'Your payment is still open';
                    break;
                case MollieEnum::PAID:
                    $flash_message = 'Your payment was completed successfully!';
                    break;
                case MollieEnum::UNKNOWN:
                    $flash_message = 'Unknown error';
                    break;
            }

            Session::flash('flash_message', $flash_message);
        }

        if (Session::has('mollie_paid_tickets')) {
            $event_id = Session::get('mollie_paid_tickets');
            Session::remove('mollie_paid_tickets');
            $isMember = Auth::user()->is_member;

            switch (MollieTransaction::translateStatus($transaction->status)) {
                case MollieEnum::FAILED:
                    if ($isMember) {
                        $flash_message = 'Your payment has failed, the tickets are still yours but they are now listed as a withdrawal.';
                    } else {
                        $flash_message = 'Your payment has failed, the tickets have not been added to your account, please retry the purchase.';
                    }

                    break;
                case MollieEnum::OPEN:
                    $flash_message = 'Your payment is still open, the payment can still be completed.';
                    break;
                case MollieEnum::PAID:
                    $flash_message = 'Your payment was completed successfully! The tickets have been mailed to you!';
                    break;
                case MollieEnum::UNKNOWN:
                    $flash_message = 'Unknown error';
            }

            Session::flash('flash_message', $flash_message);

            return to_route('event::show', ['event' => Event::getPublicId($event_id)]);
        }

        return to_route('omnomcom::orders::index');
    }

    /**
     * @throws Exception
     */
    public function webhook(int $id): void
    {
        /** @var MollieTransaction $transaction */
        $transaction = MollieTransaction::query()->findOrFail($id);
        $transaction->updateFromWebhook();
        abort(200, 'Mollie webhook processed correctly!');
    }

    /**
     * @param  int[]  $orderlines
     * @return MollieTransaction
     *
     * @throws ApiException
     */
    public static function createPaymentForOrderlines(array $orderlines)
    {
        $total = OrderLine::query()->whereIn('id', $orderlines)->sum('total_price');

        /** @var MollieTransaction $transaction */
        $transaction = MollieTransaction::query()->create([
            'user_id' => Auth::id(),
            'mollie_id' => 'temp',
            'status' => 'draft',
        ]);

        $total = number_format($total, 2, '.', '');
        $properties = [
            'amount' => [
                'currency' => 'EUR',
                'value' => $total,
            ],
            'method' => null,
            'description' => 'OmNomCom Settlement (€'.$total.')',
            'redirectUrl' => route('omnomcom::mollie::receive', ['id' => $transaction->id]),
        ];

        if (Config::boolean('omnomcom.mollie.has_webhook')) {
            $properties['webhookUrl'] = route('webhook::mollie', ['id' => $transaction->id]);
        }

        $mollie = Mollie::api()
            ->payments
            ->create($properties);

        $transaction->mollie_id = $mollie->id;
        $transaction->amount = $mollie->amount->value;
        $transaction->payment_url = $mollie->getCheckoutUrl();
        $transaction->save();

        OrderLine::query()->whereIn('id', $orderlines)->update(['payed_with_mollie' => $transaction->id]);

        return $transaction;
    }

    /**
     * @return int
     */
    public static function getTotalForMonth(string $month): mixed
    {
        $month = Date::parse($month);
        $start = $month->copy()->startOfMonth();
        if ($start->isWeekend()) {
            $start->nextWeekday();
        }

        $end = $month->copy()->addMonth()->startOfMonth();
        if ($end->isWeekend()) {
            $end->nextWeekday();
        }

        return OrderLine::query()->whereHas('molliePayment', static function ($query) use ($start, $end) {
            $query->whereIn('status', Config::array('omnomcom.mollie.paid_statuses'))
                ->whereBetween('created_at', [$start, $end]);
        })
            ->sum('total_price');
    }

    /**
     * @return null|Collection<int, object{status: string, resource: string, id: string, description?: string, pricing?: mixed}>
     *
     * @throws ApiException
     */
    public static function getPaymentMethods(): ?Collection
    {
        if (App::environment('local')) {
            return null;
        }

        $api_response = Mollie::api()
            ->methods
            ->allActive([
                'locale' => 'nl_NL',
                'billingCountry' => 'NL',
                'include' => 'pricing',
            ]);
        $methodsList = (array) $api_response;

        foreach ($api_response as $index => $method) {
            if ($method->status != 'activated' || $method->resource != 'method') {
                unset($methodsList[$index]);
            }

            if (in_array($method->id, Config::array('omnomcom.mollie.free_methods'))) {
                $methodsList[$index]->pricing = null;
                $methodsList[$index]->pricing[0] = (object) [
                    'description' => $method->description,
                    'fixed' => (object) [
                        'value' => '0.00',
                        'currency' => 'EUR',
                    ],
                    'variable' => '0',
                ];
            }
        }

        return collect($methodsList);
    }
}
