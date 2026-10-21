<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestForgery as Middleware;
use Override;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     */
    #[Override]
    protected $except = [
        'webhook/*',
        'api/*',
        'image/*',
        'file/*',
        // Saml2 (surfconext) callback location
        'surf/callback',
    ];
}
