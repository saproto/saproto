<?php

namespace App\Http\Middleware;

use App\Models\HashMapItem;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class EnforceWizard
{
    /**
     * Handle an incoming request.
     *
     *
     * @throws Exception
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (! $request->is('api/*') && Auth::check() && ! Auth::user()->is_member) {
            $id = Auth::id();
            $wizard = Cache::remember("user_wizard_{$id}", 60, fn () => HashMapItem::query()->key('wizard')->subkey((string) Auth::id())->exists());
            if ($wizard) {
                if (! $request->is('becomeamember')) {
                    return to_route('becomeamember');
                }
                HashMapItem::query()
                    ->key('wizard')
                    ->subkey((string) $id)
                    ->delete();

                Cache::forget("user_wizard_{$id}");
            }
        }

        return $next($request);
    }
}
