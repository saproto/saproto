<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;

class LdapController extends Controller
{
    /**
     * @param string $query
     * @param bool $only_active
     * @return array
     */
    public static function searchUtwente(string $query, bool $only_active = false)
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

    public static function searchStudents(): array
    {
        return Cache::remember('ldap_utwente_students', 3600, function () {
            $ldap_students = LdapController::searchUtwente('|(department=*B-CREA*)(department=*M-ITECH*)');

            $names = [];
            $emails = [];
            $usernames = [];

        foreach ($ldap_students as $student) {
            $names[] = strtolower($student->givenname.' '.$student->sn);
            $emails[] = strtolower($student->userprincipalname);
            $usernames[] = $student->uid;
        }
        $client = new Client();
        try {
            // Make a POST request to the LDAP Proxy
            $response = $client->post(config('ldap.proxy.utwente.post_url'), [
                'form_params' => [
                    'key' => config('ldap.proxy.utwente.key'),
                    'query' => $query
                ]
            ]);

            // Get the response body
            $body = $response->getBody();
            $content = json_decode($body->getContents(), true);
            Cache::put($cacheKey, $content, 3600);
            // Return the response content
            return (object)[
                'result' => $content
            ];
        } catch (\Exception $e) {
            // Handle exceptions
            return (object)[
                'error' => $e->getMessage()
            ];
        }
    }
}


