<?php

namespace Illuminate\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Vite;

class AddLinkHeadersForPreloadedAssets
{
    /**
     * Handle the incoming request.
     **/
    public function handle(Request $request, Closure $next): Response
    {
        return tap($next($request), function ($response) {
            if (Vite::preloadedAssets() !== []) {
                $response->header('Link', Collection::make(Vite::preloadedAssets())
                    ->map(fn ($attributes, $url): string => "<{$url}>; ".implode('; ', $attributes))
                    ->join(', '));
            }
        });
    }
}
