<?php

namespace App\Http\Controllers;

use App\Models\StorageEntry;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\EncodedImageInterface;
use League\Flysystem\FilesystemException;

class FileController extends Controller
{
    /**
     * @param  int  $id
     * @param  string  $hash
     */
    public function get($id, $hash): Response
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
     * @throws FilesystemException
     */
    public static function makeImage(StorageEntry $entry, ?int $w = null, ?int $h = null): EncodedImageInterface
    {
        ini_set('memory_limit', '512M');
        $manager = new ImageManager(new Driver);

        if (Storage::disk('local')->has($entry->filename)) {
            $image = $manager->read(Storage::disk('local')->path($entry->filename));
        } else {
            abort(404, 'File not found');
        }

        $cacheKey = 'image:'.$entry->hash.'; w:'.$w.'; h:'.$h;

        if ($w === null || $w === 0 || ($h === null || $h === 0)) {
            return Cache::remember($cacheKey, 86400, fn (): EncodedImageInterface => $image->scaleDown($w, $h)->encode());
        }

        return Cache::remember($cacheKey, 86400, fn (): EncodedImageInterface => $image->coverDown($w, $h)->encode());
    }

    /**
     * @param  int  $id
     * @param  string  $hash
     */
    public function getImage($id, $hash, Request $request): Response
    {
        /** @var StorageEntry $entry */
        $entry = StorageEntry::query()->findOrFail($id);

        if ($hash != $entry->hash) {
            abort(404);
        }

        $response = new Response(static::makeImage($entry, ($request->has('w') ? $request->input('w') : null), ($request->has('h') ? $request->input('h') : null)), 200);
        $response->header('Content-Type', $entry->mime);
        $response->header('Cache-Control', 'max-age=86400, public');
        $response->header('Content-Disposition', sprintf('filename="%s"', $entry->original_filename));

        return $response;
    }

    /**
     * @param  string  $printer
     * @param  string  $url
     * @param  int  $copies
     */
    public static function requestPrint($printer, $url, $copies = 1): string
    {
        if ($printer == 'document') {
            return 'You cannot do this at the moment. Please use the network printer.';
        }

        $payload = base64_encode(json_encode((object) [
            'secret' => Config::string('app-proto.printer-secret'),
            'url' => $url,
            'printer' => $printer,
            'copies' => $copies,
        ]));

        $result = null;
        try {
            $result = file_get_contents('http://'.Config::string('app-proto.printer-host').':'.Config::string('app-proto.printer-port').'/?data='.$payload);
        } catch (Exception $exception) {
            return 'Exception while connecting to the printer server: '.$exception->getMessage();
        }

        return $result !== false ? $result : 'Something went wrong while connecting to the printer server.';
    }
}
