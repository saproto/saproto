<?php

namespace App\Http\Controllers;

use App\Data\OrderlineData;
use App\Models\Activity;
use App\Models\Event;
use App\Models\OrderLine;
use App\Models\TicketPurchase;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Inertia\Inertia;
use Inertia\Response;

class WrappedController extends Controller
{
    public function index(): Response
    {
        $from = Date::now()->startOfYear();
        $to = Date::now()->endOfYear();

        //        const stats = {};
        //    //Activities
        //    stats.activities = {};
        //
        //    stats.activities.amount = events.length;
        //    stats.activities.spent = events.length <= 0 ? 0 : events.map(x => x.price).reduce((a, b) => a + b).toFixed(2);
        //    stats.activities.all = events;
        //    //Calories
        //    stats.calories = {};
        //    stats.calories.amount = orders.map(x => x.units * x.product.calories).reduce((a, b) => a + b);
        //    stats.calories.tostis = Math.round(stats.calories.amount / 251);
        //    // const beerOrders = orders.filter(x => x.product.is_alcoholic);
        //    // stats.calories.actualBeers = beerOrders.length <= 0 ? 0 : beerOrders.map(x => x.units).reduce((a, b) => a + b);
        //
        //    //DaysAtProto
        //    stats.days = {}
        //    stats.days.items = 0;
        //    let days = {};
        //    for (let order of orders) {
        //        const date = order.created_at.substring(0, 10);
        //        if (!(date in days)) days[date] = 0;
        //        days[date] += order.units;
        //        stats.days.items += order.units;
        //    }
        //
        //    stats.days.amount = Object.keys(days).length;
        //
        //    //Drinks
        //    stats.drinks = {};
        //    stats.drinks.alcoholic = 0;
        //    stats.drinks.nonAlcoholic = 0;
        //    let drinks = {};
        //
        //    for (let order of orders) {
        //        if (order.product.name.startsWith('TIPcie')) {
        //            const date = order.created_at.substring(0, 10);
        //            if (!(date in drinks)) drinks[date] = 0;
        //            drinks[date] += order.units;
        //            if (order.product.is_alcoholic === 1) {
        //                stats.drinks.alcoholic += order.units;
        //            } else {
        //                stats.drinks.nonAlcoholic += order.units;
        //            }
        //        }
        //    }
        //
        //    stats.drinks.amount = Object.keys(drinks).length;
        //
        //    stats.omnomcomdays = new Set(orders.map(x => x.created_at.slice(5, 10)));
        //
        //    //MostBought
        //    let filteredOrders = orders.filter(x => ![
        //        825,
        //        826,
        //        827,
        //        831,
        //        841,
        //        855,
        //        881,
        //        883,
        //        975,
        //        979,
        //        980,
        //        986,
        //        998,
        //        1181,
        //        1184,
        //        1185,
        //        1197,
        //        1198,
        //        1199,
        //        1200,
        //        1201,
        //        1358
        //    ].includes(x.product_id))
        //    stats.mostBought = {};
        //    let totals = {};
        //    for (let order of filteredOrders) {
        //        if (order.product.name in totals) totals[order.product.name][1] += order.units;
        //        else totals[order.product.name] = [order.product, order.units];
        //    }
        //    stats.mostBought.items = Object.values(totals).sort((a, b) => b[1] - a[1]);
        //    let otherOrders = order_totals[stats.mostBought.items[0][0].id];
        //    if (stats.mostBought.items[0][1] === otherOrders[otherOrders.length - 1]) {
        //        stats.mostBought.percentile = 0;
        //    } else {
        //        let percentileCount = 0;
        //        for (const order of otherOrders) {
        //            if (stats.mostBought.items[0][1] <= order) {
        //                break
        //            }
        //            percentileCount++;
        //        }
        //        stats.mostBought.percentile = Math.round((otherOrders.length - percentileCount) / otherOrders.length * 100);
        //    }
        //
        //
        //    //NoStreepDecember
        //    stats.december = {};
        //    stats.december.complete = true;
        //    stats.december.items = 0;
        //    for (let order of orders) {
        //        const month = order.created_at.substring(5, 7);
        //        if (month === '12') {
        //            stats.december.complete = false;
        //            stats.december.items += order.units;
        //        }
        //    }
        //
        //    //TotalSpent
        //    stats.totalSpent = {};
        //    stats.totalSpent.amount = orders.map(x => x.total_price).reduce((a, b) => a + b);
        //    stats.totalSpent.total = total_spent;
        //
        //    //WillToLive
        //    stats.willToLives = {};
        //    const willToLives = orders.filter(x => x.product.id === 987).map(el => el.units);
        //    stats.willToLives.amount = willToLives.length > 0 ? willToLives.reduce((a, b) => a + b) : 0;
        //
        //    let otherWills = order_totals['987'];
        //    stats.willToLives.percentage = Math.log(stats.willToLives.amount) / Math.log(otherWills[otherWills.length - 1])
        //    let percentileCountWills = 0;
        //    for (const order of otherWills) {
        //        if (stats.willToLives.amount <= order) {
        //            break
        //        }
        //        percentileCountWills++;
        //    }
        //    stats.willToLives.percentile = Math.round((otherWills.length - percentileCountWills) / otherWills.length * 100);
        return Inertia::render('Wrapped/Wrapped',
            [
                'order_totals' => $this->orderTotals(),
                'purchases' => OrderlineData::collect($this->getPurchases($from, $to, Auth::user())->get()),
                'total_spent' => round($this->getPurchases($from, $to)->sum('total_price'), 2),
                'events' => $this->eventList(),
            ]);

        //
        //        return new JsonResponse([
        //            'order_totals' => $this->orderTotals(),
        //            'purchases' => OrderlineData::collect($this->getPurchases($from, $to, Auth::user())->get()),
        //            'total_spent' => round($this->getPurchases($from, $to)->sum('total_price'), 2),
        //            'events' => $this->eventList(),
        //            'user' => auth()->user(),
        //        ], 200, [], JSON_NUMERIC_CHECK);
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
