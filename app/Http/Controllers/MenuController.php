<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;

use Illuminate\Support\Facades\Redirect;
use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;
use Proto\Models\MenuItem;
use Proto\Models\Page;

use Session;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menuItems = MenuItem::where('parent', null)->with('children', 'page')->orderBy('order')->get();

        return view("menu.list", ['menuItems' => $menuItems]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Router $router)
    {
        $pages = Page::all();
        $topMenuItems = MenuItem::where('parent', null)->orderBy('order')->get();

        return view("menu.edit", ['item' => null, 'pages' => $pages, 'new' => true, 'topMenuItems' => $topMenuItems, 'routes' => $router->getRoutes()->getRoutes()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $menuItem = new MenuItem($request->all());

        if ($request->has('is_member_only')) {
            $menuItem->is_member_only = true;
        } else {
            $menuItem->is_member_only = false;
        }

        if ($request->page_id == 0) $menuItem->page_id = null;
        if ($request->parent == 0) $menuItem->parent = null;

        if ($menuItem->page_id) {
            $menuItem->url = Page::find($menuItem->page_id)->getUrl();
        }

        $maxOrder = MenuItem::where('parent', $menuItem->parent)->orderBy('order', 'DESC')->first();

        if ($maxOrder) {
            $menuItem->order = $maxOrder->order + 1;
        } else {
            $menuItem->order = 0;
        }

        $menuItem->save();
        $this->fixDuplicateMenuItemsOrder($menuItem->parent);

        return Redirect::route("menu::list");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Router $router, $id)
    {
        $menuItem = MenuItem::findOrFail($id);
        $pages = Page::all();
        $topMenuItems = MenuItem::where('parent', null)->orderBy('order')->get();

        return view("menu.edit", ['item' => $menuItem, 'pages' => $pages, 'new' => false, 'topMenuItems' => $topMenuItems, 'routes' => $router->getRoutes()->getRoutes()]);
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
        $menuItem = MenuItem::findOrFail($id);

        if ($request->parent != $menuItem->parent) {
            $oldparent = $menuItem->parent;
        }

        $menuItem->menuname = $request->menuname;
        $menuItem->url = $request->url;
        $menuItem->page_id = $request->page_id;
        $menuItem->parent = $request->parent;

        if ($request->page_id == 0) $menuItem->page_id = null;
        if ($request->parent == 0) $menuItem->parent = null;

        $maxOrder = MenuItem::where('parent', $menuItem->parent)->orderBy('order', 'DESC')->first();

        if ($maxOrder) {
            $menuItem->order = $maxOrder->order + 1;
        } else {
            $menuItem->order = 0;
        }

        if ($request->has('is_member_only')) {
            $menuItem->is_member_only = true;
        } else {
            $menuItem->is_member_only = false;
        }

        if ($menuItem->page_id) {
            $menuItem->url = Page::find($menuItem->page_id)->getUrl();
        }

        $menuItem->save();

        $this->fixDuplicateMenuItemsOrder($oldparent);
        $this->fixDuplicateMenuItemsOrder($menuItem->parent);

        return Redirect::route("menu::list");
    }

    public function orderUp($id)
    {
        $menuItem = MenuItem::findOrFail($id);

        $menuItemAbove = MenuItem::where('parent', $menuItem->parent)->where('order', '<', $menuItem->order)->orderBy('order', 'desc')->first();

        if (!$menuItemAbove) abort(400, 'Item is already top item.');

        $this->switchMenuItems($menuItem, $menuItemAbove);
        $this->fixDuplicateMenuItemsOrder($menuItem->parent);

        return Redirect::route("menu::list");
    }

    public function orderDown($id)
    {
        $menuItem = MenuItem::findOrFail($id);

        $menuItemBelow = MenuItem::where('parent', $menuItem->parent)->where('order', '>', $menuItem->order)->orderBy('order', 'asc')->first();

        if (!$menuItemBelow) abort(400, 'Item is already bottom item.');

        $this->switchMenuItems($menuItem, $menuItemBelow);
        $this->fixDuplicateMenuItemsOrder($menuItem->parent);

        return Redirect::route("menu::list");
    }

    private function switchMenuItems($item1, $item2)
    {
        $newOrderForItem1 = $item2->order;
        $newOrderForItem2 = $item1->order;

        $item1->order = $newOrderForItem1;
        $item2->order = $newOrderForItem2;

        $item1->save();
        $item2->save();
    }

    private function fixDuplicateMenuItemsOrder($parent)
    {
        $menuItems = MenuItem::where('parent', $parent)->orderBy('order', 'asc')->get();
        $i = 0;
        foreach ($menuItems as $menuItem) {
            $menuItem->order = $i;
            $menuItem->save();
            $i++;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menuItem = MenuItem::findOrfail($id);

        if ($menuItem->children->count() > 0) {
            Session::flash('flash_message', 'A menu item with children can\'t be removed.');
            return Redirect::route('menu::list');
        }

        $change = MenuItem::where('parent', '=', $menuItem->parent)->get();

        foreach ($change as $item) {
            if ($item->order > $menuItem->order && $item->id != $menuItem->id) {
                $item->order = $item->order - 1;
                $item->save();
            }
        }

        Session::flash('flash_message', 'Menu item has been removed.');

        $menuItem->delete();

        return Redirect::route('menu::list');
    }
}
