<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\OrderLine;
use Proto\Models\Ticket;
use Proto\Models\Event;
use Proto\Models\Product;

use Proto\Models\TicketPurchase;
use Redirect;
use Session;

use Auth;
use PDF;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('tickets.index', ['tickets' => Ticket::orderBy('id', 'desc')->get()]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('tickets.edit', ['ticket' => null]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $ticket = new Ticket();
        $ticket->event_id = Event::findOrFail($request->input('event'))->id;
        $ticket->product_id = Product::findOrFail($request->input('product'))->id;
        $ticket->members_only = $request->has('is_members_only');
        $ticket->available_from = strtotime($request->input('available_from'));
        $ticket->available_to = strtotime($request->input('available_to'));
        $ticket->save();

        Session::flash("flash_message", "The ticket has been created!");
        return Redirect::route('tickets::list');

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        return view('tickets.edit', ['ticket' => $ticket]);
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
        $ticket = Ticket::findOrFail($id);

        $ticket->event_id = Event::findOrFail($request->input('event'))->id;
        $ticket->product_id = Product::findOrFail($request->input('product'))->id;
        $ticket->members_only = $request->has('is_members_only');
        $ticket->available_from = strtotime($request->input('available_from'));
        $ticket->available_to = strtotime($request->input('available_to'));
        $ticket->save();

        Session::flash("flash_message", "The ticket has been updated!");
        return Redirect::route('tickets::list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        if ($ticket->purchases()->count() > 0) {
            Session::flash("flash_message", "This ticket has already been sold, you cannot remove it!");
            return Redirect::back();
        }
        $ticket->delete();

        Session::flash("flash_message", "The ticket has been deleted!");
        return Redirect::route('tickets::list');
    }

    public function download($id)
    {
        $ticket = TicketPurchase::findOrFail($id);
        if ($ticket->user->id != Auth::id()) {
            abort(403, "This is not your ticket!");
        }


        return PDF::loadView('tickets.download', ['ticket' => $ticket])->stream();
    }

    /**
     * Buy tickets for a specific event.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function buyForEvent(Request $request, $id)
    {

        if (!Auth::user()->bank()) {
            Session::flash("flash_message", "You can only buy event tickets if you have an active withdrawal organization. Please .");
            return Redirect::back();
        }

        $event = Event::findOrFail($id);
        if ($event->tickets->count() < 1) {
            Session::flash("flash_message", "There are no tickets available for this event.");
            return Redirect::back();
        }

        foreach ($request->get('tickets') as $ticket_id => $amount) {
            $ticket = Ticket::find($ticket_id);
            if (!$ticket) {
                Session::flash("flash_message", "Ticket ID#$ticket_id is not an existing ticket. Entire order cancelled.");
                return Redirect::back();
            }
            if ($ticket->members_only && !Auth::user()->member) {
                Session::flash("flash_message", "Ticket ID#$ticket_id is only available to members. You are not a member. Entire order cancelled.");
                return Redirect::back();
            }
            if ($ticket->event->id != $event->id) {
                Session::flash("flash_message", "Ticket ID#$ticket_id is not a ticket for event '" . $event->title . "'. Entire order cancelled.");
                return Redirect::back();
            }
            if ($amount > config('proto.maxtickets')) {
                Session::flash("flash_message", "You tried to more then " . config('proto.maxtickets') . " of ticket '" . $ticket->product->name . "', you can only buy " . config('proto.maxtickets') . " at a time. Entire order cancelled.");
                return Redirect::back();
            }
            if ($amount > $ticket->product->stock) {
                Session::flash("flash_message", "You tried to buy $amount of ticket '" . $ticket->product->name . "', but only " . $ticket->product->title . " are available. Entire order cancelled.");
                return Redirect::back();
            }
        }

        foreach ($request->get('tickets') as $ticket_id => $amount) {

            $ticket = Ticket::find($ticket_id);

            for ($i = 0; $i < $amount; $i++) {

                $oid = $ticket->product->buyForUser(Auth::user(), 1, $ticket->product->price);

                $purchase = TicketPurchase::create([
                    'ticket_id' => $ticket_id,
                    'orderline_id' => $oid,
                    'user_id' => Auth::id(),
                    'barcode' => $oid . mt_rand(10000000000000000000,99999999999999999999),
                ]);
                $purchase->save();

            }

        }

        Session::flash("flash_message", "Order completed succesfully! You can find your tickets on this event page.");
        return Redirect::back();

    }
}
