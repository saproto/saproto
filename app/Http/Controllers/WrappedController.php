<?php

namespace App\Http\Controllers;

use App\Data\OrderlineData;
use App\Models\Activity;
use App\Models\Event;
use App\Models\OrderLine;
use App\Models\TicketPurchase;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class WrappedController extends Controller
{
    public function index(): JsonResponse
    {
        $from = Date::now()->startOfYear();
        $to = Date::now()->endOfYear();

        return new JsonResponse([
            'order_totals' => $this->orderTotals(),
            'purchases' => OrderlineData::collect($this->getPurchases($from, $to, Auth::user())->get()),
            'total_spent' => round($this->getPurchases($from, $to)->sum('total_price'), 2),
            'events' => $this->eventList(),
            'user' => auth()->user(),
        ], 200, [], JSON_NUMERIC_CHECK);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder<OrderLine>
     */
    public function getPurchases(Carbon $from, Carbon $to, ?User $user = null)
    {
        return OrderLine::query()
            ->when($user !== null, function (\Illuminate\Database\Eloquent\Builder $query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with('product.media')
            ->where('created_at', '>', $from)
            ->where('created_at', '<', $to)
            ->orderBy('created_at', 'DESC');
    }

    /** @return Collection<(int|string), Collection<(int|string), mixed>>*/
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
     * @return Collection<int, array{
     *     title: string,
     *     start: int,
     *     location: string,
     *     formatted_date: string,
     *     price: float|int,
     *     image_url: string|null
     * }>
     */
    public function eventList(): Collection
    {
        $events = Event::query()
            ->whereBetween('start', [now()->startOfYear()->timestamp, now()->endOfYear()->timestamp])
            ->whereNotLike('title', '%cancel%')
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
