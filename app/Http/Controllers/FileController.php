<?php

namespace App\Http\Controllers;

use App\Models\StorageEntry;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\EncodedImageInterface;

class FileController extends Controller
{
    public function get(int $id, string $hash): Response
    {
        /** @var StorageEntry $entry */
        $entry = StorageEntry::query()->findOrFail($id);

        if ($hash != $entry->hash) {
            abort(404);
        }

        $file = Storage::disk('local')->get($entry->filename);

        $response = new Response($file, 200);
        $response->header('Content-Type', $entry->mime);
        $response->header('Cache-Control', 'max-age=86400, public');
        $response->header('Content-Disposition', sprintf('attachment; filename="%s"', $entry->original_filename));

        return $response;
    }

    /**
     * @return EncodedImageInterface
     */
    public static function makeImage(StorageEntry $entry, ?int $w = null, ?int $h = null): string
    {
        $cacheKey = 'image:'.$entry->hash.'; w:'.$w.'; h:'.$h;
        if (Storage::disk('local')->missing($entry->filename)) {
            abort(404, 'File not found');
        }

        return Cache::rememberForever($cacheKey, function () use ($entry, $w, $h): string {
            $manager = new ImageManager(new Driver);

            $image = $manager->read(Storage::disk('local')->get($entry->filename));
            if (empty($w) || empty($h)) {
                return $image->scaleDown($w, $h)->encode()->toString();
            }

            return $image->coverDown($w, $h)->encode()->toString();
        });
    }

    /**
     * @return Response
     */
    public function getImage(int $id, string $hash, Request $request)
    {
        /** @var StorageEntry $entry */
        $entry = StorageEntry::query()->findOrFail($id);

        if ($hash != $entry->hash) {
            abort(404);
        }

        return Response(static::makeImage($entry, $request->input('w'), $request->input('h')), 200, [
            'Content-Type' => $entry->mime,
            'Cache-Control' => 'max-age=86400, public',
            'Content-Disposition', sprintf('filename="%s"', $entry->original_filename),
        ]);
    }

    public static function requestPrint(string $printer, string $url, int $copies = 1): string
    {
        if ($printer === 'document') {
            return 'You cannot do this at the moment. Please use the network printer.';
        }

        $payload = base64_encode(json_encode((object) [
            'secret' => config('app-proto.printer-secret'),
            'url' => $url,
            'printer' => $printer,
            'copies' => $copies,
        ]));

        $result = null;
        try {
            $result = file_get_contents('http://'.config('app-proto.printer-host').':'.config('app-proto.printer-port').'/?data='.$payload);
        } catch (Exception $exception) {
            return 'Exception while connecting to the printer server: '.$exception->getMessage();
        }

        return $result !== false ? $result : 'Something went wrong while connecting to the printer server.';
    }
}
