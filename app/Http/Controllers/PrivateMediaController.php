<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PrivateMediaController extends Controller
{
    public function show(int $mediaId, ?string $conversion = null): StreamedResponse
    {
        $media = Media::query()->findOrFail($mediaId);
        $disk = $conversion ? $media->conversions_disk : $media->disk;
        abort_if($disk === 'public' || $disk === 'garage-public', 403, 'This is not a private media file.');

        $path = $media->getPathRelativeToRoot($conversion ?? '');

        return Storage::disk($disk)->response($path, $media->file_name, [
            'Cache-Control' => 'private, max-age=3600',
            'Pragma' => 'public',
        ]);
    }

    public function showResponsive($mediaId)
    {
        return $mediaId;
        $media = Media::query()->findOrFail($mediaId);
        return $media->responsive_images;
        $disk = $conversion ? $media->conversions_disk : $media->disk;
        abort_if($disk === 'public' || $disk === 'garage-public', 403, 'This is not a private media file.');

        $path = $media->getPathRelativeToRoot($conversion ?? '');

        return Storage::disk($disk)->response($path, $media->file_name, [
            'Cache-Control' => 'private, max-age=3600',
            'Pragma' => 'public',
        ]);
    }
}
