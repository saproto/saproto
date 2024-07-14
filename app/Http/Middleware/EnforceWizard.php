<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\HashMapItem;
use Closure;
use Exception;
use Illuminate\Http\Request;

class EnforceWizard
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     *
     * @throws Exception
     */
    public function handle($request, $next)
    {
        if (Auth::check() && HashMapItem::key('wizard')->subkey((string)Auth::user()->id)->first() && !$request->is('api/*')) {
            if (!$request->is('becomeamember')) {
                return Redirect::route('becomeamember');
            }

            HashMapItem::key('wizard')->subkey((string)Auth::user()->id)->first()->delete();
        }

        return $next($request);
    }
}
