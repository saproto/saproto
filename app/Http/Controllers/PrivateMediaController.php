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

        if ($media->disk !== 'local') {
            abort(403, 'This is not a private media file.');
        }

        $path = $conversion ? $media->getPathRelativeToRoot($conversion) : $media->getPathRelativeToRoot();

        if ($conversion && ! Storage::disk($media->disk)->exists($path)) {
            $path = $media->getPathRelativeToRoot();
        }

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
