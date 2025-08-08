<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Response;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PrivateMediaController extends Controller
{
    public function show(int $mediaId, string $conversion = null): StreamedResponse
    {
        $media = Media::query()->findOrFail($mediaId);

        $conversionPath =  empty($conversion) ? null : $media->getPathRelativeToRoot($conversion);
        if (!empty($conversionPath) && $media->conversions_disk==='public' || $media->disk === 'public') {
            abort(403, 'This is not a private media file.');
        }

        if ($conversionPath && Storage::disk($media->conversions_disk)->exists($conversionPath)) {
            $path = $media->getPathRelativeToRoot($conversion);
            return Response::stream(function () use ($media, $path) {
                echo Storage::disk($media->conversions_disk)->get($path);
            }, 200, [
                'Content-Type' => $media->mime_type,
                'Content-Disposition' => 'inline; filename="'.$media->file_name.'"',
                'Cache-Control' => 'private, max-age=3600',
                'Pragma' => 'public',
            ]);
        }


        $path = $media->getPathRelativeToRoot();
        if (! Storage::disk($media->disk)->exists($path)) {
            abort(404, 'Media file not found.');
        }

        return Response::stream(function () use ($media, $path) {
            echo Storage::disk($media->disk)->get($path);
        }, 200, [
            'Content-Type' => $media->mime_type,
            'Content-Disposition' => 'inline; filename="'.$media->file_name.'"',
            'Cache-Control' => 'private, max-age=3600',
            'Pragma' => 'public',
        ]);
    }
}
