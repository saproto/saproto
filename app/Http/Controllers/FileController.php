<?php

namespace App\Http\Controllers;

use App\Models\StorageEntry;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function get(int $id, string $hash): Response
    {
        $entry = Cache::remember('file-entry:'.$id, 31536000, fn (): StorageEntry => StorageEntry::query()->findOrFail($id));

        abort_if($hash != $entry->hash, 404);

        $file = Storage::disk('local')->get($entry->filename);

        $response = new Response($file, 200);
        $response->header('Content-Type', $entry->mime);
        $response->header('Cache-Control', 'max-age=86400, public');
        $response->header('Content-Disposition', sprintf('attachment; filename="%s"', $entry->original_filename));

        return $response;
    }

    public static function requestPrint(string $printer, string $url, int $copies = 1): string
    {
        if ($printer === 'document') {
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
