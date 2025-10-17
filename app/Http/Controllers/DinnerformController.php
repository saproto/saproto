<?php

namespace App\Http\Controllers;

use App\Models\Dinnerform;
use App\Models\DinnerformOrderline;
use App\Models\Product;
use Carbon\CarbonImmutable;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class DinnerformController extends Controller
{
    public function show(int $id): View|RedirectResponse
    {
        /** @var Dinnerform $dinnerform */
        $dinnerform = Dinnerform::query()
            ->with('event')->findOrFail($id);
        $order = DinnerformOrderline::query()
            ->where('user_id', Auth::user()->id)
            ->where('dinnerform_id', $dinnerform->id)
            ->first();

        if (! $dinnerform->isCurrent() && ! $order) {
            Session::flash('flash_message', 'This dinnerform is closed and you have not ordered anything.');

            return back();
        }

        return view('dinnerform.show', ['dinnerform' => $dinnerform, 'order' => $order]);
    }

    public function admin(int $id): View
    {
        $dinnerform = Dinnerform::query()
            ->with('orderlines.user')
            ->with('orderlines.dinnerform')
            ->with('event')
            ->findOrFail($id);

        return view('dinnerform.admin', ['dinnerform' => $dinnerform]);
    }

    public function create(): View
    {
        $dinnerformList = Dinnerform::query()
            ->with('event')->orderBy('end', 'desc')->with('orderedBy')->paginate(20);

        return view('dinnerform.list', ['dinnerformCurrent' => null, 'dinnerformList' => $dinnerformList]);
    }

    public function store(Request $request): RedirectResponse
    {
        if ($request->input('end') < $request->input('start')) {
            Session::flash('flash_message', 'You cannot let the dinnerform close before it opens.');

            return back();
        }

        $dinnerform = Dinnerform::query()->create([
            'restaurant' => $request->input('restaurant'),
            'description' => $request->input('description'),
            'url' => $request->input('url'),
            'start' => $request->date('start')->timestamp,
            'end' => $request->date('end')->timestamp,
            'helper_discount' => $request->input('helper_discount'),
            'regular_discount' => (100 - $request->input('regular_discount')) / 100,
            'event_id' => $request->input('event_select') != '' ? $request->input('event_select') : null,
            'visible_home_page' => $request->has('homepage'),
            'ordered_by_user_id' => $request->input('ordered_by'),
        ]);

        Session::flash('flash_message', "Your dinnerform at '".$dinnerform->restaurant."' has been added.");

        return to_route('dinnerform::create');
    }

    public function edit(int $id): View|RedirectResponse
    {
        $dinnerformCurrent = Dinnerform::query()->findOrFail($id);
        if ($dinnerformCurrent->closed) {
            Session::flash('flash_message', 'You cannot update a closed dinnerform!');

            return back();
        }

        $dinnerformList = Dinnerform::query()
            ->orderBy('end', 'desc')
            ->with('orderedBy')
            ->with('event')
            ->paginate(20);

        return view('dinnerform.list', ['dinnerformCurrent' => $dinnerformCurrent, 'dinnerformList' => $dinnerformList]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        /** @var Dinnerform $dinnerform */
        $dinnerform = Dinnerform::query()->findOrFail($id);

        $request->validate([
            'start' => ['required', 'date_format:Y-m-d\TH:i'],
            'end' => ['required', 'date_format:Y-m-d\TH:i', 'after:start'],
        ]);

        if ($dinnerform->closed) {
            Session::flash('flash_message', 'You cannot update a closed dinnerform!');

            return back();
        }

        $start = CarbonImmutable::parse($request->input('start'))->timestamp;
        $end = CarbonImmutable::parse($request->input('end'))->timestamp;
        $restaurant = $request->string('restaurant');
        $changed_important_details =
            $dinnerform->start->timestamp != $start ||
            $dinnerform->end->timestamp != $end ||
            $dinnerform->restaurant != $request->input('restaurant');

        $dinnerform->update([
            'restaurant' => $restaurant,
            'description' => $request->string('description'),
            'url' => $request->input('url'),
            'start' => $start,
            'end' => $end,
            'helper_discount' => $request->input('helper_discount'),
            'regular_discount' => (100 - $request->input('regular_discount')) / 100,
            'event_id' => $request->input('event_select') != '' ? $request->input('event_select') : null,
            'visible_home_page' => $request->has('homepage'),
            'ordered_by_user_id' => $request->input('ordered_by'),
        ]);

        if ($changed_important_details) {
            Session::flash('flash_message', "Your dinnerform for '".$dinnerform->restaurant."' has been saved. You updated some important information. Don't forget to notify your participants with this info!");
        } else {
            Session::flash('flash_message', "Your dinnerform for '".$dinnerform->restaurant."' has been saved.");
        }

        return to_route('dinnerform::edit', ['id' => $dinnerform->id]);
    }

    /**
     * @throws Exception
     */
    public function destroy(int $id): RedirectResponse
    {
        $dinnerform = Dinnerform::query()->findOrFail($id);
        if (! $dinnerform->closed) {
            Session::flash('flash_message', "The dinnerform for '".$dinnerform->restaurant."' has been deleted.");
            $dinnerform->delete();
        } else {
            Session::flash('flash_message', 'The dinnerform is already closed and can not be deleted!');
        }

        return to_route('dinnerform::create');
    }

    /**
     * Close the dinnerform by changing the end time to the current time.
     */
    public function close(int $id): RedirectResponse
    {
        /** @var Dinnerform $dinnerform */
        $dinnerform = Dinnerform::query()
            ->with('orderlines.user')
            ->with('orderlines.dinnerform')
            ->findOrFail($id);

        $dinnerform->update([
            'end' => Date::now(),
        ]);

        return to_route('dinnerform::admin', ['id' => $dinnerform->id]);
    }

    public function process(int $id): RedirectResponse
    {
        if (! Auth::user()->can('finadmin')) {
            Session::flash('flash_message', 'You are not allowed to process dinnerforms!');

            return back();
        }

        $dinnerform = Dinnerform::query()->findOrFail($id);
        /** @var Dinnerform $dinnerform */
        $dinnerformOrderlines = $dinnerform->orderlines()->where('closed', false)->get();
        $product = Product::query()->findOrFail(Config::integer('omnomcom.dinnerform-product'));
        /** @var Product $product */
        if ($dinnerform->closed) {
            Session::flash('flash_message', 'This dinnerform has already been processed!');

            return back();
        }

        foreach ($dinnerformOrderlines as $dinnerformOrderline) {
            $product->buyForUser(
                $dinnerformOrderline->user,
                1,
                $dinnerformOrderline->price_with_discount,
                null,
                null,
                sprintf("Dinnerform from %s, ordered at $dinnerform->restaurant", Date::parse($dinnerform->end)->format('d-m-Y')),
                sprintf('dinnerform_orderline_processed_by_%u', Auth::user()->id)
            );
            $dinnerformOrderline->closed = true;
            $dinnerformOrderline->save();
        }

        $dinnerform->closed = true;
        $dinnerform->save();

        return to_route('dinnerform::create')->with('flash_message', "All orderlines of $dinnerform->restaurant have been processed!");
    }
}
