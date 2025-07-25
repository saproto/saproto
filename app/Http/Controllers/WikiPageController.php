<?php

namespace App\Http\Controllers;

use App\Models\WikiPage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WikiPageController extends Controller
{

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required'],
            'slug' => ['required'],
            'full_path' => ['required'],
            'parent_id' => ['nullable', 'integer'],
            'content' => ['required'],
        ]);

        return WikiPage::query()->create($data);
    }

    public function show($path = null)
    {
        $page = WikiPage::where('full_path', $path)->first();
        $children = $page
            ? $page->children()->orderBy('title')->get()
            : WikiPage::whereNull('parent_id')->orderBy('title')->get();
        return Inertia::render('wiki/Show', [
            'page' => $page,
            'children' => $children,
        ]);
    }

    public function edit(string $path)
    {
        $path = trim($path, '/'); // remove leading/trailing slashes

        $page = WikiPage::query()->with('parent')->where('full_path', $path)->first();

        if (! $page) {
            abort(404);
        }

        return view('wiki.edit', [
            'page'=>$page,
            'children' =>$page->children]);
    }

    public function update(Request $request, WikiPage $wikiPage): WikiPage
    {
        $data = $request->validate([
            'title' => ['required'],
            'slug' => ['required'],
            'full_path' => ['required'],
            'parent_id' => ['nullable', 'integer'],
            'content' => ['required'],
        ]);

        $wikiPage->update($data);

        return $wikiPage;
    }

    public function destroy(WikiPage $wikiPage)
    {
        $wikiPage->delete();

        return response()->json();
    }
}
