<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;
use Proto\Models\Bank;
use Proto\Models\OrderLine;
use Proto\Models\User;
use Proto\Models\Withdrawal;

use Redirect;
use Response;
use Mail;
use Auth;

class WithdrawalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("omnomcom.withdrawals.index", ['withdrawals' => Withdrawal::orderBy('id', 'desc')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("omnomcom.withdrawals.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $max = ($request->has('max') ? $request->input('max') : null);
        if ($max <= 0) {
            $max = null;
        }

        $date = strtotime($request->input('date'));
        if ($date === false) {
            $request->session()->flash('flash_message', 'Invalid date.');
            return Redirect::back();
        }

        $withdrawal = Withdrawal::create([
            'date' => date('Y-m-d', $date)
        ]);

        $totalPerUser = [];
        foreach (OrderLine::whereNull('payed_with_withdrawal')->get() as $orderline) {

            if ($orderline->isPayed()) continue;
            if ($orderline->user->bank == null && $orderline->user->backupBank == null) continue;

            if ($max != null) {
                if (!array_key_exists($orderline->user->id, $totalPerUser)) {
                    $totalPerUser[$orderline->user->id] = 0;
                }

                if ($totalPerUser[$orderline->user->id] + $orderline->total_price > $max) continue;
            }

            $orderline->withdrawal()->associate($withdrawal);
            $orderline->save();

            if ($max != null) {
                $totalPerUser[$orderline->user->id] += $orderline->total_price;
            }

        }

        return Redirect::route('omnomcom::withdrawal::show', ['id' => $withdrawal->id]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view("omnomcom.withdrawals.show", ['withdrawal' => Withdrawal::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $withdrawal = Withdrawal::findOrFail($id);

        if ($withdrawal->closed) {
            $request->session()->flash('flash_message', 'This withdrawal is already closed and cannot be edited.');
            return Redirect::back();
        }

        $date = strtotime($request->input('date'));
        if ($date === false) {
            $request->session()->flash('flash_message', 'Invalid date.');
            return Redirect::back();
        }

        $withdrawal->date = date('Y-m-d', $date);
        $withdrawal->save();

        $request->session()->flash('flash_message', 'Withdrawal updated.');
        return Redirect::route('omnomcom::withdrawal::show', ['id' => $withdrawal->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $withdrawal = Withdrawal::findOrFail($id);

        if ($withdrawal->closed) {
            $request->session()->flash('flash_message', 'This withdrawal is already closed and cannot be deleted.');
            return Redirect::back();
        }

        foreach ($withdrawal->orderlines as $orderline) {
            $orderline->withdrawal()->dissociate();
            $orderline->save();
        }

        $withdrawal->delete();

        $request->session()->flash('flash_message', 'Withdrawal deleted.');
        return Redirect::route('omnomcom::withdrawal::list');
    }

    /**
     * Delete a user from the specified withdrawal.
     *
     * @param $id Withdrawal id.
     * @param $user_id User id.
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function deleteFrom(Request $request, $id, $user_id)
    {
        $withdrawal = Withdrawal::findOrFail($id);

        if ($withdrawal->closed) {
            $request->session()->flash('flash_message', 'This withdrawal is already closed and cannot be edited.');
            return Redirect::back();
        }

        $user = User::findOrFail($user_id);

        foreach ($withdrawal->orderlinesForUseR($user) as $orderline) {
            $orderline->withdrawal()->dissociate();
            $orderline->save();
        }

        $request->session()->flash('flash_message', 'Orderlines for ' . $user->name . ' removed from this withdrawal.');
        return Redirect::back();
    }

    /**
     * Generates a CSV file for the withdrawal and returns a download.
     *
     * @param $id Withdrawal id.
     * @return \Illuminate\Http\Response
     */
    public static function export(Request $request, $id)
    {
        $withdrawal = Withdrawal::findOrFail($id);

        $seperator = ',';
        $response = implode($seperator, ['withdrawal_type', 'total', 'bank_machtigingid', 'signature_date', 'bank_bic', 'name', 'bank_iban', 'email']) . "\n";

        foreach ($withdrawal->users() as $user) {
            $response .= implode($seperator, [
                    (($user->bank ? $user->bank->is_first : $user->backupBank->is_first) ? 'FRST' : 'RCUR'),
                    number_format($withdrawal->totalForUser($user), 2, '.', ''),
                    ($user->bank ? $user->bank->machtigingid : $user->backupBank->machtigingid),
                    date('Y-m-d', strtotime(($user->bank ? $user->bank->created_at : $user->backupBank->created_at))),
                    ($user->bank ? $user->bank->bic : $user->backupBank->bic),
                    $user->name,
                    ($user->bank ? $user->bank->iban : $user->backupBank->iban),
                    $user->email
                ]) . "\n";
        }

        $headers = [
            'Content-Encoding' => 'UTF-8',
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="withdrawal-' . $withdrawal->id . '.csv"'
        ];

        return Response::make($response, 200, $headers);
    }

    /**
     * Close a withdrawal so no more changes can be made.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function close(Request $request, $id)
    {
        $withdrawal = Withdrawal::findOrFail($id);

        if ($withdrawal->closed) {
            $request->session()->flash('flash_message', 'This withdrawal is already closed and cannot be edited.');
            return Redirect::back();
        }

        foreach ($withdrawal->users() as $user) {
            if ($user->bank) {
                $user->bank->is_first = false;
                $user->bank->save();
            } else {
                $user->backupBank->is_first = false;
                $user->backupBank->save();
            }
        }

        $withdrawal->closed = true;
        $withdrawal->save();

        foreach (Bank::onlyTrashed()->get() as $trashedBank) {
            if (!$trashedBank->user->hasUnpaidOrderlines()) {
                $trashedBank->forceDelete();
            }
        }

        $request->session()->flash('flash_message', 'The withdrawal is now closed. Changes cannot be made anymore.');
        return Redirect::back();
    }

    public function showForUser(Request $request, $id)
    {
        $withdrawal = Withdrawal::findOrFail($id);
        return view('omnomcom.withdrawals.userhistory', ['withdrawal' => $withdrawal, 'orderlines' => $withdrawal->orderlinesForUser(Auth::user())]);
    }

    /**
     * Send an e-mail to all users in the withdrawal to notice them.
     *
     * @param $id Withdrawal id.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function email(Request $request, $id)
    {
        $withdrawal = Withdrawal::findOrFail($id);

        if ($withdrawal->closed) {
            $request->session()->flash('flash_message', 'This withdrawal is already closed so e-mails cannot be sent.');
            return Redirect::back();
        }

        foreach ($withdrawal->users() as $user) {
            $data = [
                'name' => $user->name,
                'email' => $user->email,
                'date' => $withdrawal->date
            ];
            Mail::queue('emails.omnomcom.withdrawalnotification', ['user' => $user, 'withdrawal' => $withdrawal], function ($message) use ($data) {
                $message
                    ->to($data['email'], $data['name'])
                    ->from('treasurer@' . config('proto.emaildomain'), config('proto.treasurer'))
                    ->subject('S.A. Proto Withdrawal Announcement for ' . date('d-m-Y', strtotime($data['date'])));
            });
        }

        $request->session()->flash('flash_message', 'All e-mails have been queued.');
        return Redirect::back();
    }

    /**
     * @return int The current sum of orderlines that are open.
     */
    public static function openOrderlinesSum()
    {
        $sum = 0;
        foreach (OrderLine::whereNull('payed_with_withdrawal')->get() as $orderline) {
            if ($orderline->isPayed()) continue;
            $sum += $orderline->total_price;
        }
        return $sum;
    }

    /**
     * @return int The total number of orderlines that are open.
     */
    public static function openOrderlinesTotal()
    {
        $total = 0;
        foreach (OrderLine::whereNull('payed_with_withdrawal')->get() as $orderline) {
            if ($orderline->isPayed()) continue;
            $total++;
        }
        return $total;
    }
}
