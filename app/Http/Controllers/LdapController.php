<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;

class LdapController extends Controller
{
    public static function searchUtwente(string $query, bool $only_active = false): array
    {
        $response = file_get_contents(sprintf('%s?key=%s&filter=(%s)', config('ldap.proxy.utwente.url'), config('ldap.proxy.utwente.key'), urlencode($query)));
        if ($response === false) {
            abort(500, 'Could not connect to LDAP proxy.');
        }

        $result = json_decode($response)->result;

        if ($only_active) {
            return array_filter($result, static fn ($row): bool => (bool) $row->active);
        }

        return $result ?? [];
    }

    public static function searchUtwentePost(string $query): object
    {
        $cacheKey = md5($query);

        if (Cache::has($cacheKey)) {
            return (object) [
                'result' => Cache::get($cacheKey),
            ];
        }

        $client = new Client;
        try {
            // Make a POST request to the LDAP Proxy
            $response = $client->post(config('ldap.proxy.utwente.post_url'), [
                'form_params' => [
                    'key' => config('ldap.proxy.utwente.key'),
                    'query' => $query,
                ],
            ]);

            // Get the response body
            $body = $response->getBody();
            $content = json_decode($body->getContents(), true);
            Cache::put($cacheKey, $content, 3600 * 60);

            // Return the response content
            return (object) [
                'result' => $content,
            ];
        } catch (Exception|GuzzleException $e) {
            // Handle exceptions
            return (object) [
                'error' => $e->getMessage(),
            ];
        }
    }
}
