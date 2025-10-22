<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Milon\Barcode\DNS2D;

class ShortUrlController extends Controller
{
    public function index(): View
    {
        $urls = ShortUrl::query()->orderBy('url')->paginate(25);

        return view('short_url.index', ['urls' => $urls]);
    }

    public function create(): View
    {
        return view('short_url.edit', ['url' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            ShortUrl::query()->create($request->all());
            Session::flash('flash_message', 'New URL created!');
        } catch (UniqueConstraintViolationException) {
            Session::flash('flash_message', 'A shortlink with this URL already exists!');
        }

        return to_route('short_urls.index');
    }

    public function edit(ShortUrl $short_url): View
    {
        return view('short_url.edit', ['url' => $short_url]);
    }

    public function update(Request $request, ShortUrl $short_url): RedirectResponse
    {
        try {
            $short_url->update($request->all());
            Session::flash('flash_message', 'Short URL updated!');
        } catch (UniqueConstraintViolationException) {
            Session::flash('flash_message', 'A shortlink with this URL already exists!');
        }

        return to_route('short_urls.index');
    }

    public function destroy(ShortUrl $short_url): RedirectResponse
    {
        $short_url->delete();

        Session::flash('flash_message', 'Short URL deleted!');

        return to_route('short_urls.index');
    }

    public function qrCode(int $id): Response
    {
        $url = ShortUrl::query()->findOrFail($id);

        return response((new DNS2D)->getBarcodeSVG(sprintf('https://%s', $url->target), 'QRCODE,M'))->header('Content-Type', 'image/svg+xml');
    }

    public function go(string $short): RedirectResponse
    {
        $url = ShortUrl::query()->where('url', $short)->firstOrFail();
        $url->clicks++;
        $url->save();

        return Redirect::to(sprintf('https://%s', $url->target));
    }
}
