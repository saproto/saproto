<?php

namespace App\Http\Controllers;

use App\Models\EventCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class EventCategoryController extends Controller
{
    public function create()
    {
        return view('event.categories', ['cur_category' => null]);
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'name' => 'required|string|min:5',
            'icon' => 'required|string|min:5|starts_with:fa',
        ]);
        $category = EventCategory::create($validated);

        Session::flash('flash_message', 'The category '.$category->name.' has been created.');

        return Redirect::route('event::categories.edit', ['category' => $category]);
    }

    public function edit(EventCategory $category)
    {
        return view('event.categories', ['cur_category' => $category]);
    }

    public function update(Request $request, EventCategory $category)
    {
        $validated = $this->validate($request, [
            'name' => 'required|string|min:5',
            'icon' => 'required|string|min:5|starts_with:fa',
        ]);

        $category->update($validated);

        Session::flash('flash_message', 'The category '.$category->name.' has been updated.');

        return Redirect::route('event::categories.edit', ['category' => $category]);
    }

    public function destroy(EventCategory $category)
    {
        $category->events()->update(['category_id' => null]);
        $category->delete();

        Session::flash('flash_message', 'The category '.$category->name.' has been deleted.');

        return Redirect::route('event::categories.create');
    }
}
