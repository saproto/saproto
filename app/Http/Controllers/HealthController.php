<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Throwable;

class HealthController extends Controller
{

    public function health(): Response
    {
        if (! $this->checkDatabase() || ! $this->checkCache()) {
            return response('unhealthy', 503);
        }

        return response('ok', 200);
    }
    private function checkDatabase(): bool
    {
        try {
            DB::connection()->getPdo();
            DB::select('SELECT 1');

            return true;
        } catch (Throwable) {
            return false;
        }
    }

    private function checkCache(): bool
    {
        try {
            $key = 'health_check_probe';
            Cache::put($key, 'ok', now()->addSeconds(5));

            return Cache::get($key) === 'ok';
        } catch (Throwable) {
            return false;
        }
    }
}
