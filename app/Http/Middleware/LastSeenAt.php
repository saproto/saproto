<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;
use Symfony\Component\HttpFoundation\Response;

class LastSeenAt
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request):Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $id = Auth::id();
            $cacheKey = "last-seen-at::user::{$id}";
            $now = Date::now();
            $lastSeen = Cache::get($cacheKey);
            if (! $lastSeen || $now->diffInHours($lastSeen) >= 12) {
                Cache::put($cacheKey, $now);
                Auth::user()->update(['last_seen_at' => $now]);
            }
        }

        return $next($request);
    }
}
