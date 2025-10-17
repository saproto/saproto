<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Exception;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class PageController extends Controller
{
    /**
     * These slugs can't be used for pages, as they are used by the app.
     *
     * @var string[]
     */
    protected array $reservedSlugs = ['add', 'edit', 'delete'];

    /** @return View */
    public function index(): \Illuminate\Contracts\View\View|Factory
    {
        $pages = Page::query()->orderBy('created_at', 'desc')->paginate(20);

        return view('pages.list', ['pages' => $pages]);
    }

    /** @return View */
    public function create(): \Illuminate\Contracts\View\View|Factory
    {
        return view('pages.edit', ['item' => null, 'new' => true]);
    }

    /**
     * @return RedirectResponse|View
     */
    public function store(Request $request)
    {
        $page = new Page($request->all());

        $page->is_member_only = $request->has('is_member_only');

        $page->show_attachments = $request->has('show_attachments');

        if (in_array($request->slug, $this->reservedSlugs)) {
            Session::flash('flash_message', "This URL has been reserved and can't be used. Please choose a different URL.");

            return view('pages.edit', ['item' => $page, 'new' => true]);
        }

        if (Page::query()->where('slug', $page->slug)->exists()) {
            Session::flash('flash_message', "This URL has already been used and can't be used again. Please choose a different URL.");

            return view('pages.edit', ['item' => $page, 'new' => true]);
        }

        $page->save();

        Session::flash('flash_message', "Page $page->title has been created.");

        return to_route('page::list');
    }

    /**
     * @return View
     */
    public function show(string $slug): \Illuminate\Contracts\View\View|Factory
    {
        $page = Page::query()->where('slug', '=', $slug)->first();

        if ($page == null) {
            abort(404, 'Page not found.');
        }

        if ($page->is_member_only && ! Auth::user()?->is_member) {
            abort(403, 'You need to be a member of S.A. Proto to see this page.');
        }

        return view('pages.show', ['page' => $page, 'parsedContent' => Markdown::convert($page->content)]);
    }

    /**
     * @return View
     */
    public function edit(int $id): \Illuminate\Contracts\View\View|Factory
    {
        $page = Page::query()->findOrFail($id);

        return view('pages.edit', ['item' => $page, 'new' => false]);
    }

    /**
     * @return RedirectResponse|View
     */
    public function update(Request $request, int $id)
    {
        /** @var Page $page */
        $page = Page::query()->findOrFail($id);

        if (($request->slug != $page->slug) && Page::query()->where('slug', $page->slug)->exists()) {
            Session::flash('flash_message', "This URL has been reserved and can't be used. Please choose a different URL.");

            return view('pages.edit', ['item' => $request, 'new' => false]);
        }

        $page->fill($request->all());

        $page->is_member_only = $request->has('is_member_only');

        $page->show_attachments = $request->has('show_attachments');

        if (in_array($request->slug, $this->reservedSlugs)) {
            Session::flash('flash_message', "This URL has been reserved and can't be used. Please choose a different URL.");

            return view('pages.edit', ['item' => $page, 'new' => false]);
        }

        $page->save();

        Session::flash('flash_message', 'Page '.$page->title.' has been saved.');

        return to_route('page::list');
    }

    /**
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function destroy(int $id)
    {
        /** @var Page $page */
        $page = Page::query()->findOrfail($id);

        Session::flash('flash_message', 'Page '.$page->title.' has been removed.');

        $page->delete();

        return to_route('page::list');
    }

    /**
     * @return RedirectResponse
     */
    public function addFile(Request $request, int $id)
    {
        $request->validate([
            'file' => ['required', 'file', 'max:5120', 'mimes:pdf,jpg,png,jpeg'], // max 5MB
        ]);
        $page = Page::query()->findOrFail($id);

        try {
            if (in_array($request->file('file')->getMimeType(), ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'])) {
                $collection = 'images';
            } else {
                $collection = 'files';
            }

            $page->addMediaFromRequest('file')
                ->toMediaCollection($collection);
        } catch (FileDoesNotExist|FileIsTooBig $e) {
            Session::flash('flash_message', $e->getMessage());

            return back();
        }

        return to_route('page::edit', ['id' => $id]);
    }

    /**
     * @return RedirectResponse
     */
    public function deleteFile(int $id, int $file_id)
    {
        $page = Page::query()->findOrFail($id);
        $item = $page->media()->where('id', $file_id)->firstOrFail();
        $item->delete();

        return to_route('page::edit', ['id' => $id]);
    }
}
