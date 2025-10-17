<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Page;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function index(): View
    {
        $menuItems = MenuItem::query()
            ->whereNull('parent')
            ->with('page')
            ->with('children')
            ->orderBy('order')
            ->get();

        return view('menu.list', ['menuItems' => $menuItems]);
    }

    public function create(Router $router): View
    {
        $pages = Page::all();
        $topMenuItems = MenuItem::query()->where('parent')->orderBy('order')->get();

        return view('menu.edit', ['item' => null, 'pages' => $pages, 'topMenuItems' => $topMenuItems, 'routes' => $this->getAllRoutes($router)]);
    }

    public function store(Request $request): RedirectResponse
    {
        $menuItem = new MenuItem;
        $menuItem->menuname = $request->input('name');
        $menuItem->parent = $request->input('parent') ?: null;
        $menuItem->is_member_only = $request->has('is_member_only');
        $menuItem->page_id = $request->input('page_id') ?: null;
        $menuItem->url = $menuItem->page_id ? Page::query()->find($menuItem->page_id)->getUrl() : $request->input('url');

        $maxOrder = MenuItem::query()->where('parent', $menuItem->parent)->orderBy('order', 'DESC')->first();
        $menuItem->order = $maxOrder ? $maxOrder->order + 1 : 0;
        $menuItem->save();

        $this->fixDuplicateMenuItemsOrder($menuItem->parent);

        Cache::forget('website.navbar');

        return to_route('menu::list');
    }

    public function edit(Router $router, int $id): View
    {
        $menuItem = MenuItem::query()->findOrFail($id);
        $pages = Page::all();
        $topMenuItems = MenuItem::query()->where('parent', null)->orderBy('order')->get();

        return view('menu.edit', ['item' => $menuItem, 'pages' => $pages, 'topMenuItems' => $topMenuItems, 'routes' => $this->getAllRoutes($router)]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        /** @var MenuItem $menuItem */
        $menuItem = MenuItem::query()->findOrFail($id);

        if ($request->input('parent') != $menuItem->parent) {
            $oldparent = $menuItem->parent;
        }

        $menuItem->menuname = $request->input('name');
        $menuItem->parent = $request->input('parent') ?: null;
        $menuItem->is_member_only = $request->has('is_member_only');
        $menuItem->page_id = $request->input('page_id') ?: null;
        $menuItem->url = $menuItem->page_id ? Page::query()->find($menuItem->page_id)->getUrl() : $request->input('url');

        $maxOrder = MenuItem::query()->where('parent', $menuItem->parent)->orderBy('order', 'DESC')->first();
        $menuItem->order = $maxOrder ? $maxOrder->order + 1 : 0;
        $menuItem->save();

        if (isset($oldparent)) {
            $this->fixDuplicateMenuItemsOrder($oldparent);
        }

        $this->fixDuplicateMenuItemsOrder($menuItem->parent);
        Cache::forget('website.navbar');

        return to_route('menu::list');
    }

    public function orderUp(int $id): RedirectResponse
    {
        /** @var MenuItem $menuItem */
        $menuItem = MenuItem::query()->findOrFail($id);
        $menuItemAbove = MenuItem::query()->where('parent', $menuItem->parent)->where('order', '<', $menuItem->order)->orderBy('order', 'desc')->first();

        abort_unless($menuItemAbove, 400, 'Item is already top item.');

        $this->switchMenuItems($menuItem, $menuItemAbove);
        $this->fixDuplicateMenuItemsOrder($menuItem->parent);
        Cache::forget('website.navbar');

        return to_route('menu::list');
    }

    public function orderDown(int $id): RedirectResponse
    {
        /** @var MenuItem $menuItem */
        $menuItem = MenuItem::query()->findOrFail($id);
        $menuItemBelow = MenuItem::query()->where('parent', $menuItem->parent)->where('order', '>', $menuItem->order)->orderBy('order', 'asc')->first();

        abort_unless($menuItemBelow, 400, 'Item is already bottom item.');

        $this->switchMenuItems($menuItem, $menuItemBelow);
        $this->fixDuplicateMenuItemsOrder($menuItem->parent);
        Cache::forget('website.navbar');

        return to_route('menu::list');
    }

    private function switchMenuItems(MenuItem $item1, MenuItem $item2): void
    {
        $newOrderForItem1 = $item2->order;
        $newOrderForItem2 = $item1->order;

        $item1->order = $newOrderForItem1;
        $item2->order = $newOrderForItem2;

        $item1->save();
        $item2->save();
    }

    private function fixDuplicateMenuItemsOrder(MenuItem $parent): void
    {
        $menuItems = MenuItem::query()->where('parent', $parent->id)->orderBy('order')->get();
        $i = 0;
        foreach ($menuItems as $menuItem) {
            $menuItem->order = $i;
            $menuItem->save();
            $i++;
        }
    }

    /**
     * @throws Exception
     */
    public function destroy(int $id): RedirectResponse
    {
        /** @var MenuItem $menuItem */
        $menuItem = MenuItem::query()->findOrfail($id);

        if ($menuItem->children->count() > 0) {
            Session::flash('flash_message', "A menu item with children can't be removed.");

            return to_route('menu::list');
        }

        $change = MenuItem::query()->where('parent', '=', $menuItem->parent)->get();

        foreach ($change as $item) {
            if ($item->order > $menuItem->order && $item->id != $menuItem->id) {
                $item->order--;
                $item->save();
            }
        }

        Session::flash('flash_message', 'Menu item has been removed.');
        $menuItem->delete();
        Cache::forget('website.navbar');

        return to_route('menu::list');
    }

    /**
     * @return array<string>
     */
    private function getAllRoutes(Router $router): array
    {
        $routes = $router->getRoutes()->getRoutesByMethod()['GET'];

        return array_filter($routes, static fn ($route): bool => $route->getName() &&
            ! str_contains($route->uri(), '{') &&
            ! str_contains($route->getName(), 'api::') &&
            ! str_contains($route->getName(), 'login::') &&
            ! str_contains($route->uri(), 'oauth'));
    }
}
