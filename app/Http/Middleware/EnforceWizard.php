<?php

namespace Proto\Http\Middleware;

use Auth;
use Closure;
use Proto\Models\HashMapItem;
use Redirect;

class EnforceWizard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && HashMapItem::key('wizard')->subkey(Auth::user()->id)->first() && !$request->is('api/*')) {
            if (!$request->is('becomeamember')) {
                return Redirect::route('becomeamember');
            }
            HashMapItem::key('wizard')->subkey(Auth::user()->id)->first()->delete();
        }
        return $next($request);
    }
}
