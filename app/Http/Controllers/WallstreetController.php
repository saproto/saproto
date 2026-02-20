<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\WallstreetDrink;
use App\Models\WallstreetEvent;
use App\Models\WallstreetPrice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class WallstreetController extends Controller
{
    public function index(): View
    {
        $allDrinks = WallstreetDrink::query()->orderby('start_time', 'desc')->get();

        return view('wallstreet.admin', ['allDrinks' => $allDrinks, 'currentDrink' => null]);
    }

    public function statistics(int $id): View
    {
        return view('wallstreet.price-history', ['id' => $id]);
    }

    public function marquee(): View|RedirectResponse
    {
        $activeDrink = WallstreetController::active();

        if (! $activeDrink instanceof WallstreetDrink) {
            Session::flash('flash_message', 'There is no active drink to show the marquee screen for!');

            return back();
        }

        $prices = $this->getLatestPrices($activeDrink);
        $sound_path = asset('sounds/kaching.mp3');

        return view('wallstreet.marquee', ['activeDrink' => $activeDrink, 'prices' => $prices, 'sound_path' => $sound_path]);
    }

    public function edit(int $id): View
    {
        $currentDrink = WallstreetDrink::query()->find($id);
        $allDrinks = WallstreetDrink::query()->orderby('start_time', 'desc')->get();

        return view('wallstreet.admin', ['allDrinks' => $allDrinks, 'currentDrink' => $currentDrink]);
    }

    public function store(Request $request): View
    {
        $drink = new WallstreetDrink;
        $drink->start_time = $request->date('start_time')->timestamp;
        $drink->end_time = $request->date('end_time')->timestamp;
        $drink->minimum_price = $request->input('minimum_price');
        $drink->price_increase = $request->input('price_increase');
        $drink->price_decrease = $request->input('price_decrease');
        $drink->random_events_chance = $request->input('random_events_chance');
        $drink->save();

        $allDrinks = WallstreetDrink::query()->orderby('start_time', 'desc')->get();
        Session::flash('flash_message', 'Wallstreet drink created. Do not forget to add products below!');

        return view('wallstreet.admin', ['allDrinks' => $allDrinks, 'currentDrink' => $drink]);
    }

    public function update(Request $request, int $id): View
    {
        $drink = WallstreetDrink::query()->findOrFail($id);
        $drink->start_time = $request->date('start_time')->timestamp;
        $drink->end_time = $request->date('end_time')->timestamp;
        $drink->minimum_price = $request->input('minimum_price');
        $drink->price_increase = $request->input('price_increase');
        $drink->price_decrease = $request->input('price_decrease');
        $drink->random_events_chance = $request->input('random_events_chance');
        $drink->save();

        $allDrinks = WallstreetDrink::query()->orderby('start_time', 'desc')->get();

        return view('wallstreet.admin', ['allDrinks' => $allDrinks, 'currentDrink' => $drink]);
    }

    public function destroy(int $id): RedirectResponse
    {
        $drink = WallstreetDrink::query()->findOrFail($id);
        foreach ($drink->products as $product) {
            $drink->products()->detach($product->id);
        }

        $drink->delete();

        $prices = WallstreetPrice::query()->where('wallstreet_drink_id', $id)->get();
        foreach ($prices as $price) {
            $price->delete();
        }

        Session::flash('flash_message', 'Wallstreet drink and its affiliated price history deleted.');

        return Redirect::to(route('wallstreet::index'));
    }

    public function close(int $id): RedirectResponse
    {
        /** @var WallstreetDrink $drink */
        $drink = WallstreetDrink::query()->findOrFail($id);
        $drink->end_time = Date::now()->timestamp;
        $drink->save();
        Session::flash('flash_message', 'Wallstreet drink closed.');

        return back();
    }

    public function addProducts(int $id, Request $request): RedirectResponse
    {
        /** @var WallstreetDrink $drink */
        $drink = WallstreetDrink::query()->findOrFail($id);
        $products = $request->input('product');
        $products = array_unique($products);
        foreach ($products as $product) {
            $drink->products()->syncWithoutDetaching($product);
        }

        Session::flash('flash_message', count($products).' Products added to Wallstreet drink.');

        return Redirect::to(route('wallstreet::edit', ['id' => $id]));
    }

    public function removeProduct(int $id, int $productId): RedirectResponse
    {
        /** @var WallstreetDrink $drink */
        $drink = WallstreetDrink::query()->findOrFail($id);
        $drink->products()->detach($productId);
        Session::flash('flash_message', 'Product removed from Wallstreet drink.');

        return back();
    }

    public static function active(): ?WallstreetDrink
    {
        return WallstreetDrink::query()->where('start_time', '<=', Date::now()->timestamp)->where('end_time', '>=', Date::now()->timestamp)->first();
    }

    /**
     * @return Collection<int, Product>
     */
    public function getLatestPrices(WallstreetDrink $drink): Collection
    {
        $products = $drink->products()->select('name', 'price', 'id')->with('media')->get();
        foreach ($products as $product) {
            /** @var Product $product */
            /** @phpstan-ignore-next-line */
            $product->img = $product->getImageUrl();

            $newPrice = WallstreetPrice::query()->where('product_id', $product->id)->orderBy('id', 'desc')->first();
            if (! $newPrice || $product->price === 0.0) {
                $product->price = $newPrice->price ?? $product->price;
                /** @phpstan-ignore-next-line */
                $product->diff = 0;

                continue;
            }

            /** @phpstan-ignore-next-line */
            $product->diff = ($newPrice->price - $product->price) / $product->price * 100;
            $product->price = $newPrice->price;
        }

        return $products;
    }

    public function getUpdatedPricesJSON(int $drinkID): JsonResponse
    {
        $drink = WallstreetDrink::query()->findOrFail($drinkID);
        $prices = $this->getLatestPrices($drink);
        $wrapped = ['products' => $prices];

        return Response::json($wrapped);
    }

    /**
     * @return Collection<int, Product>
     */
    public function getAllPrices(int $drinkID)
    {
        return WallstreetDrink::query()->find($drinkID)->products()->with('wallstreetPrices', static function ($q) use ($drinkID) {
            $q->where('wallstreet_drink_id', $drinkID)->orderBy('id', 'asc');
        })->select('id', 'name')->get();
    }

    public function events(): View
    {
        $allEvents = WallstreetEvent::all();

        return view('wallstreet.admin_includes.wallstreetdrink-events', ['allEvents' => $allEvents, 'currentEvent' => null]);
    }

    public function addEvent(Request $request): RedirectResponse
    {
        $event = new WallstreetEvent;
        $event->name = $request->input('title');
        $event->description = $request->input('description');
        $event->percentage = $request->integer('percentage');

        $event->save();
        Session::flash('flash_message', 'Wallstreet event created. Do not forget to add products above!');

        return Redirect::to(route('wallstreet::events::edit', ['id' => $event->id]));
    }

    public function updateEvent(Request $request, int $id): RedirectResponse
    {
        $event = WallstreetEvent::query()->findOrFail($id);
        $event->name = $request->input('title');
        $event->description = $request->input('description');
        $event->percentage = $request->integer('percentage');
        $event->save();

        return Redirect::to(route('wallstreet::events::edit', ['id' => $id]));
    }

    public function editEvent(int $id): View
    {
        $currentEvent = WallstreetEvent::query()->find($id);
        $allEvents = WallstreetEvent::all();

        return view('wallstreet.admin_includes.wallstreetdrink-events', ['allEvents' => $allEvents, 'currentEvent' => $currentEvent]);
    }

    public function destroyEvent(int $id): RedirectResponse
    {
        $currentEvent = WallstreetEvent::query()->findOrFail($id);
        /** @var WallstreetEvent $currentEvent */
        $currentEvent->products()->detach();
        $currentEvent->save();
        $currentEvent->delete();

        return Redirect::to(route('wallstreet::events::index'));
    }

    public function toggleEvent(Request $request): JsonResponse
    {
        $event = WallstreetEvent::query()->findOrFail($request->input('id'));
        /** @var WallstreetEvent $event */
        $event->active = ! $event->active;
        $event->save();

        return Response::json(['active' => $event->active, 'id' => $event->id]);
    }

    public function addEventProducts(int $id, Request $request): RedirectResponse
    {
        $event = WallstreetEvent::query()->findOrFail($id);
        $products = $request->input('product');
        $products = array_unique($products);
        foreach ($products as $product) {
            $event->products()->syncWithoutDetaching($product);
        }

        Session::flash('flash_message', count($products).' Products added to Wallstreet event.');

        return Redirect::to(route('wallstreet::events::edit', ['id' => $id]));
    }

    public function removeEventProduct(int $id, int $productId): RedirectResponse
    {
        $event = WallstreetEvent::query()->findOrFail($id);
        /** @var WallstreetEvent $event */
        $event->products()->detach($productId);
        Session::flash('flash_message', 'Product removed from Wallstreet Event.');

        return back();
    }
}
