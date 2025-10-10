<?php

namespace App\Http\Controllers;

use App\Models\HeaderImage;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class HeaderImageController extends Controller
{
    public function index(): View
    {
        return view('headerimages.index', ['images' => HeaderImage::query()->with('user')->paginate(5)]);
    }

    public function create(): View
    {
        return view('headerimages.add');
    }

    /**
     * @throws FileNotFoundException
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'user' => 'required|integer',
            'image' => 'required|image:jpeg,png,jpg|max:5120',
        ]);

        $header = HeaderImage::query()->create([
            'title' => $validated['title'],
            'credit_id' => $validated['user'],
        ]);
        $header->save();

        if ($request->has('image')) {
            try {
                $header->addMediaFromRequest('image')
                    ->usingFileName('header_'.$header->id)
                    ->toMediaCollection();
            } catch (FileDoesNotExist|FileIsTooBig $e) {
                Session::flash('flash_message', $e->getMessage());
                $header->delete();

                return Redirect::back();
            }
        }

        return Redirect::route('headerimages.index');
    }

    public function destroy(HeaderImage $headerimage): RedirectResponse
    {
        $headerimage->delete();
        Session::flash('flash_message', 'Header image deleted.');

        return Redirect::route('headerimages.index');
    }
}
