<?php

namespace App\Http\Controllers;

use App\Models\StickerType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class StickerTypeController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'min:1', 'max:20'],
            'image' => ['required', 'image:jpeg,png,jpg', 'max:5120'],
        ]);

        $stickerType = StickerType::query()->create([
            'title' => $request->string('title'),
        ]);

        try {
            $stickerType->addMediaFromRequest('image')
                ->usingFileName('stickerType_'.$stickerType->id)
                ->toMediaCollection();
        } catch (FileDoesNotExist|FileIsTooBig $e) {
            Session::flash('flash_message', $e->getMessage());
            $stickerType->delete();

            return back();
        }
        Session::flash('flash_message', $stickerType->title.' added!');

        return back();
    }

    public function update(Request $request, StickerType $stickerType): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'min:1', 'max:20'],
            'image' => ['nullable', 'image:jpeg,png,jpg', 'max:5120'],
        ]);

        $stickerType->update([
            'title' => $request->string('title'),
        ]);
        if ($request->hasFile('image')) {
            try {
                $stickerType->addMediaFromRequest('image')
                    ->usingFileName('stickerType_'.$stickerType->id)
                    ->toMediaCollection();
            } catch (FileDoesNotExist|FileIsTooBig $e) {
                Session::flash('flash_message', $e->getMessage());

                return back();
            }
        }

        return back();
    }
}
