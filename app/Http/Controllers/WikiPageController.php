<?php

namespace App\Http\Controllers;

use App\Models\WikiPage;
use Illuminate\Http\Request;

class WikiPageController extends Controller
{
    public function index()
    {
            return view('wiki.index', [
                'page'=>null,
                'children' => WikiPage::query()->whereNull('parent_id')->get()]);
    }

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

    public function show(string $path)
    {
        $path = trim($path, '/'); // remove leading/trailing slashes

        $page = WikiPage::query()->with('parent')->where('full_path', $path)->first();

        if (! $page) {
            abort(404);
        }

        return view('wiki.index', [
            'page'=>$page,
            'children' =>$page->children]);
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
