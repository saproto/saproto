<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PrivateMediaController extends Controller
{
    public function show(int $mediaId, ?string $conversion = null):  ResponseFactory|Response
    {
        $media = Cache::remember("media::{$mediaId}", Date::now()->addDays(7), fn () => Media::query()->findOrFail($mediaId));

        DB::disconnect();

        $disk = $conversion ? $media->conversions_disk : $media->disk;

        abort_if($disk === 'public' || $disk === 'garage-public', 403, 'This is not a private media file.');

        // only allow if the model is a Photo
        abort_if($media->model_type !== Photo::class, 403, 'This is not a private media file.');

        $content = Cache::store('file')->rememberForever("media::{$mediaId}::{$conversion}", function () use ($media, $conversion, $disk) {
            $path = $media->getPathRelativeToRoot($conversion ?? '');
            return Storage::disk($disk)->get($path);
        });

        return response($content, 200, [
            'Content-Type' => $media->mime_type,
            'Content-Disposition' => 'inline; filename="' . $media->file_name . '"',
            'Cache-Control' => 'private, max-age=3600',
        ]);
    }
}
