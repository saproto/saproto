<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Event;
use App\Models\OrderLine;
use App\Models\TicketPurchase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Location;

class WrappedController extends Controller
{
    public function index(): JsonResponse
    {
        $from = Carbon::now()->startOfYear();
        $to = Carbon::now()->endOfYear();
        $purchases = $this->getPurchases($from, $to);

        return response()->json([
            'order_totals' => $this->orderTotals(),
            'purchases' => $purchases,
            'total_spent' => round($purchases->sum('total_price'), 2),
            'events' => $this->eventList(),
            'user' => auth()->user(),
        ], 200, [], JSON_NUMERIC_CHECK);
    }

    /**
     * @return Collection<int, OrderLine>
     */
    public function getPurchases(Carbon $from, Carbon $to)
    {
        return OrderLine::query()->where('user_id', Auth::id())
            ->with('product')
            ->where('created_at', '>', $from)
            ->where('created_at', '<', $to)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    /** @return Collection<int, OrderLine> */
    public function orderTotals(): Collection
    {
        $totals = OrderLine::query()
            ->whereBetween('created_at', [now()->startOfYear(), now()->endOfYear()])
            ->selectRaw('product_id, SUM(units) as total')
            ->groupBy('product_id')
            ->groupBy('user_id')
            ->orderBy('product_id')
            ->orderBy('total')
            ->get();

        return $totals->groupBy('product_id')->map(static fn ($product) => $product->pluck('total'));
    }

    /**
     * @return \Illuminate\Support\Collection<int, array{
     *     title: string,
     *     start: int,
     *     location: string,
     *     formatted_date: string,
     *     price: float|int,
     *     image_url: string|null
     * }>
     */
    public function eventList(): \Illuminate\Support\Collection
    {
        $events = Event::query()
            ->whereBetween('start', [now()->startOfYear()->timestamp, now()->endOfYear()->timestamp])
            ->where(static function (\Illuminate\Contracts\Database\Query\Builder $query) {
                $query->whereIn('id', static function (Builder $query) {
                    $query->select('event_id')
                        ->from('tickets')
                        ->join('ticket_purchases', 'tickets.id', '=', 'ticket_purchases.ticket_id')
                        ->where('ticket_purchases.user_id', auth()->user()->id);
                })
                    ->orWhereIn('id', static function (Builder $query) {
                        $query->select('event_id')
                            ->from('activities')
                            ->join('activities_users', 'activities.id', '=', 'activities_users.activity_id')
                            ->where('activities_users.user_id', auth()->user()->id);
                    });
            })
            ->with('media')
            ->select(['title', 'start', 'location', 'id'])
            ->groupBy('id')
            ->orderBy('start')
            ->get();

        $activity_prices = Activity::query()
            ->whereIn('event_id', $events->pluck('id'))
            ->select(['event_id', 'price'])->get();

        $ticket_prices = TicketPurchase::query()
            ->join('tickets', 'ticket_purchases.ticket_id', '=', 'tickets.id')
            ->join('products', 'tickets.product_id', '=', 'products.id')
            ->whereIn('tickets.event_id', $events->pluck('id'))
            ->where('ticket_purchases.user_id', auth()->user()->id)
            ->selectRaw('event_id, SUM(products.price) as total')
            ->groupBy('event_id')
            ->get();

        $return = collect();

        foreach ($events as $event) {
            $returnEvent = [];
            $activity_price = $activity_prices->where('event_id', $event->id)->sum('price');
            $ticket_price = $ticket_prices->where('event_id', $event->id)->sum('total');

            $returnEvent['title'] = $event->title;
            $returnEvent['start'] = $event->start;
            $returnEvent['location'] = $event->location;
            $returnEvent['formatted_date'] = $event->start;
            $returnEvent['price'] = $activity_price + $ticket_price;
            $returnEvent['image_url'] = $event->getFirstMediaUrl('header', 'card');
            $return[] = $returnEvent;
        }

        return $return;
    }
}
