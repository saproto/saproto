<?php

namespace Proto\App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class ProTubeApiService
{
    /**
     * @var string API route prefix
     */
    private $API_PREFIX = '/api/laravel';

    /**
     * Process the response and log if any errors occur.
     *
     * @return bool successfull response
     */
    private static function assertResponse(Response $response): bool
    {
        try {
            $response->throw();
        } catch (\Exception $e) {
            \Sentry\captureException($e);
            return false;
        }
        return true;
    }

    /**
     * Skip the current song.
     *
     * @return bool skipped successfully
     */
    public static function skipSong(): bool
    {
        $response = Http::protube()->post(self::$API_PREFIX.'/skipsong');
        if (! self::assertResponse($response)) {
            return false;
        }

        $json = $response->json();
        return $json['success'];
    }

    /**
     * Trigger ProTube to update the user data for the given user id.
     *
     * @param int $userID
     * @return bool successfull response
     */
    public static function triggerWebHook(int $userID): bool
    {
        $response = Http::protube()->post(self::$API_PREFIX.'/updateadmin/'.$userID);
        if(! self::assertResponse($response)) {
            return false;
        }

        $json = $response->json();
        return $json['success'];
    }
}
