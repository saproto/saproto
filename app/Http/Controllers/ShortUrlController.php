<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class ShortUrlController extends Controller
{
    /**
     * @return View
     */
    public function index(Request $request)
    {
        $urls = ShortUrl::query()->orderBy('url')->paginate(25);

        return view('short_url.index', ['urls' => $urls]);
    }

    /**
     * @param  int  $id
     * @return View
     */
    public function edit(Request $request, $id)
    {
        $url = $id == 'new' ? null : ShortUrl::query()->findOrFail($id);

        return view('short_url.edit', ['url' => $url]);
    }

    /**
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $url = $id == 'new' ? new ShortUrl : ShortUrl::query()->findOrFail($id);
        $url->fill($request->all());
        $url->save();
        Session::flash('flash_message', 'Short URL updated!');

        return Redirect::route('short_url::index');
    }

    /**
     * @param  int  $id
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function destroy(Request $request, $id)
    {
        $url = ShortUrl::query()->findOrFail($id);
        $url->delete();

        Session::flash('flash_message', 'Short URL deleted!');

        return Redirect::route('short_url::index');
    }

    /**
     * @param  string  $short
     * @return RedirectResponse
     */
    public function go(Request $request, $short)
    {
        $url = ShortUrl::query()->where('url', $short)->firstOrFail();
        $url->clicks++;
        $url->save();

        return Redirect::to(sprintf('https://%s', $url->target));
    }
}
