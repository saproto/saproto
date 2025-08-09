<?php

namespace App\Http\Controllers;

use App\Enums\MembershipTypeEnum;
use App\Models\Activity;
use App\Models\FailedWithdrawal;
use App\Models\OrderLine;
use App\Models\Product;
use App\Models\TicketPurchase;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Mollie\Api\Exceptions\ApiException;

class OrderLineController extends Controller
{
    /**
     * @throws ApiException
     */
    public function index(?string $date = null): View
    {
        $user = Auth::user();

        $available_months = OrderLine::query()->where('user_id', $user->id)->select(
            DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
            ->groupBy('year', 'month')
            ->get()
            ->groupBy('year')
            ->map(static fn ($months) => $months->pluck('month')->sortDesc())->sortKeysDesc();

        $next_withdrawal = OrderLine::query()
            ->where('user_id', $user->id)
            ->unpayed()
            ->sum('total_price');

        $orderlines = OrderLine::query()
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->with('product:name,id', 'molliePayment:id,status')
            ->where('created_at', '>', Carbon::parse($date)->startOfMonth())
            ->where('created_at', '<=', Carbon::parse($date)->endOfMonth())
            ->get();

        $selected_month = $date ?? Carbon::now()->format('Y-m');

        $outstanding = Activity::query()
            ->whereHas('users', static function (Builder $query) {
                $query->where('user_id', Auth::user()->id);
            })->where('closed', false)
            ->with('event')->where('price', '>', 0)
            ->get();

        $outstandingAmount = $outstanding->sum('price');

        $withdrawals = $user->withdrawals()->with('failedWithdrawals', function ($q) {
            $q->where('user_id', Auth::user()->id);
        })->withSum(['orderlines' => function ($q) {
            $q->where('user_id', Auth::user()->id);
        }], 'total_price')->take(6)->get();

        $molliePayments = $user->mollieTransactions()->where('amount', '>', 0)->orderBy('created_at', 'desc')->take(6)->get();
        $payment_methods = MollieController::getPaymentMethods();

        return view('omnomcom.orders.myhistory', [
            'withdrawals' => $withdrawals,
            'available_months' => $available_months,
            'selected_month' => $selected_month,
            'orderlines' => $orderlines,
            'next_withdrawal' => $next_withdrawal,
            'total' => $orderlines->sum('total_price'),
            'methods' => $payment_methods ?? [],
            'molliePayments' => $molliePayments,
            'use_fees' => Config::boolean('omnomcom.mollie.use_fees'),
            'outstandingAmount' => $outstandingAmount,
            'outstanding' => $outstanding,
        ]);
    }

    /**
     * @return View
     */
    public function adminindex(Request $request)
    {
        $user = $request->has('user') ? User::query()->find($request->integer('user')) : null;
        $products = $request->array('product');
        $date = $request->date('date');

        $query = OrderLine::query()
            ->when(Auth::user()->can('alfred') && ! Auth::user()->hasRole('sysadmin'), function ($orderlines) {
                $orderlines->whereHas('product', static function ($products) {
                    $products->where('account_id', '=', Config::integer('omnomcom.alfred-account'));
                });
            })
            ->when($user, function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->when($date, function ($query) use ($date) {
                $query->whereDate('created_at', $date->format('Y-m-d'));
            })
            ->when($products, function ($query) use ($products) {
                $query->whereIn('product_id', $products);
            })
            ->with(['user', 'product', 'molliePayment', 'cashier:id,name'])
            ->orderBy('created_at', 'desc')
            ->paginate(20)->withQueryString();

        return view('omnomcom.orders.adminhistory', [
            'date' => $date,
            'user' => $user?->name,
            'orderlines' => $query,
            'products' => Product::query()->whereIn('id', $products)->pluck('name'),
        ]);
    }

    public function orderlineWizard(): View
    {
        $members = User::query()->whereHas('member', static function ($query) {
            $query->whereNot('membership_type', MembershipTypeEnum::PENDING);
        })->orderBy('name')->get();

        $products = Product::query()->where('is_visible', true)->orderBy('name')->get();

        return view('omnomcom.orders.admin_includes.orderline-wizard', [
            'members' => $members,
            'products' => $products,
        ]);
    }

    /**
     * @return RedirectResponse
     */
    public function bulkStore(Request $request)
    {
        $counter = count($request->input('user'));
        for ($i = 0; $i < $counter; $i++) {
            /** @var Product $product */
            $product = Product::query()->findOrFail($request->input('product')[$i]);
            $user = User::query()->findOrFail($request->input('user')[$i]);
            $price = ($request->input('price')[$i] != '' ? floatval(str_replace(',', '.', $request->input('price')[$i])) : $product->price);
            $units = $request->input('units')[$i];
            $product->buyForUser($user, $units, $price * $units, null, null, $request->input('description'), sprintf('bulk_add_by_%u', Auth::user()->id));
        }

        Session::flash('flash_message', 'Your manual orders have been added.');

        return Redirect::back();
    }

    /**
     * Store (a) simple orderline(s).
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $counter = count($request->input('user'));
        for ($u = 0; $u < $counter; $u++) {
            for ($p = 0; $p < count($request->input('product')); $p++) {
                $user = User::query()->findOrFail($request->input('user')[$u]);
                $product = Product::query()->findOrFail($request->input('product')[$p]);

                $product->buyForUser($user, 1, null, null, null, null, sprintf('simple_add_by_%u', Auth::user()->id));
            }
        }

        Session::flash('flash_message', 'Your manual orders have been added.');

        return Redirect::back();
    }

    /**
     * @param  int  $id
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function destroy(Request $request, $id)
    {
        /** @var OrderLine $order */
        $order = OrderLine::query()->findOrFail($id);

        if (! $order->canBeDeleted()) {
            Session::flash('flash_message', 'The orderline cannot be deleted.');

            return Redirect::back();
        }

        $order->product->stock += $order->units;
        $order->product->save();

        $ticketPurchase = TicketPurchase::query()->where('orderline_id', $id)->with('ticket.event')->get();
        if ($ticketPurchase->count() > 0) {
            $ticketPurchase = $ticketPurchase->first();
            $ticketPurchase->delete();
            $ticketPurchase->ticket->event->updateUniqueUsersCount();
        }

        FailedWithdrawal::query()->where('correction_orderline_id', $id)->delete();

        $order->delete();

        Session::flash('flash_message', 'The orderline was deleted.');

        return Redirect::back();
    }

    /**
     * Display aggregated payment totals for cash and card payments to check the financial administration.
     *
     * @return View
     */
    public function showPaymentStatistics(Request $request)
    {
        if ($request->has('start') && $request->has('end')) {
            $start = $request->date('start')->toDateTimeString();
            $end = $request->date('end')->toDateTimeString();
            $total_cash = DB::table('orderlines')
                ->where('created_at', '>', $start)
                ->where('created_at', '<', $end)
                ->whereNotNull('payed_with_cash')
                ->select(DB::raw('SUM(total_price) as total'))
                ->get()[0]->total;
            $total_card = DB::table('orderlines')
                ->where('created_at', '>', $start)
                ->where('created_at', '<', $end)
                ->whereNotNull('payed_with_bank_card')
                ->select(DB::raw('SUM(total_price) as total'))
                ->get()[0]->total;

            return view('omnomcom.statistics.payments', [
                'start' => $request->start,
                'end' => $request->end,
                'total_cash' => $total_cash,
                'total_card' => $total_card,
            ]);
        }

        return view('omnomcom.statistics.date-select', ['select_text' => 'Select a time range over which to calculate payment totals.']);
    }
}
