<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as BaseEncrypter;
use Override;

class EncryptCookies extends BaseEncrypter
{
    /**  The names of the cookies that should not be encrypted. */
    #[Override]
    protected $except = [
        //
    ];
}
