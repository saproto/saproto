<?php

use Illuminate\Auth\AuthServiceProvider;
use Illuminate\Broadcasting\BroadcastServiceProvider;
use Illuminate\Bus\BusServiceProvider;
use Illuminate\Cache\CacheServiceProvider;
use Illuminate\Foundation\Providers\ConsoleSupportServiceProvider;
use Illuminate\Cookie\CookieServiceProvider;
use Illuminate\Database\DatabaseServiceProvider;
use Illuminate\Encryption\EncryptionServiceProvider;
use Illuminate\Filesystem\FilesystemServiceProvider;
use Illuminate\Foundation\Providers\FoundationServiceProvider;
use Illuminate\Hashing\HashServiceProvider;
use Collective\Html\HtmlServiceProvider;
use Illuminate\Pagination\PaginationServiceProvider;
use Illuminate\Pipeline\PipelineServiceProvider;
use Illuminate\Queue\QueueServiceProvider;
use Illuminate\Redis\RedisServiceProvider;
use Illuminate\Auth\Passwords\PasswordResetServiceProvider;
use Illuminate\Session\SessionServiceProvider;
use Illuminate\Translation\TranslationServiceProvider;
use Illuminate\Validation\ValidationServiceProvider;
use Illuminate\View\ViewServiceProvider;
use Illuminate\Notifications\NotificationServiceProvider;
use App\Providers\AppServiceProvider;
use App\Providers\EventServiceProvider;
use App\Providers\RouteServiceProvider;
use Illuminate\Mail\MailServiceProvider;
use PragmaRX\Google2FA\Vendor\Laravel\ServiceProvider;
use Intervention\Image\ImageServiceProvider;
use Biscolab\ReCaptcha\ReCaptchaServiceProvider;
use Milon\Barcode\BarcodeServiceProvider;
use GrahamCampbell\Markdown\MarkdownServiceProvider;
use Mollie\Laravel\MollieServiceProvider;
use Symfony\Component\Console\Input\Input;
use willvincent\Feeds\FeedsServiceProvider;
use Vinkla\Hashids\HashidsServiceProvider;
use Aacotroneo\Saml2\Saml2ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Collective\Html\FormFacade;
use Collective\Html\HtmlFacade;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Intervention\Image\Facades\Image;
use Spipu\Html2Pdf\Html2Pdf;
use Milon\Barcode\Facades\DNS1DFacade;
use Milon\Barcode\Facades\DNS2DFacade;
use Carbon\Carbon;
use GrahamCampbell\Markdown\Facades\Markdown;
use Biscolab\ReCaptcha\Facades\ReCaptcha;
use Mollie\Laravel\Facades\Mollie;
use willvincent\Feeds\Facades\FeedsFacade;
use Vinkla\Hashids\Facades\Hashids;
use nickurt\PwnedPasswords\Facade;

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    */

    'name' => 'S.A. Proto',

    /*
    |--------------------------------------------------------------------------
    | Misc
    |--------------------------------------------------------------------------
    |
    */

    'env' => env('APP_ENV', 'local'),
    'ssl' => env('SSL', true),
    'forcedomain' => env('FORCE_DOMAIN', null),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    // This is handled in the Handler class. On production, a nice page is shown. On other environments (which should always be well protected!) the stacktrace is shown.
    'debug' => env('DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'Europe/Amsterdam',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY', 'SomeRandomString'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        AuthServiceProvider::class,
        BroadcastServiceProvider::class,
        BusServiceProvider::class,
        CacheServiceProvider::class,
        ConsoleSupportServiceProvider::class,
        CookieServiceProvider::class,
        DatabaseServiceProvider::class,
        EncryptionServiceProvider::class,
        FilesystemServiceProvider::class,
        FoundationServiceProvider::class,
        HashServiceProvider::class,
        HtmlServiceProvider::class,
        PaginationServiceProvider::class,
        PipelineServiceProvider::class,
        QueueServiceProvider::class,
        RedisServiceProvider::class,
        PasswordResetServiceProvider::class,
        SessionServiceProvider::class,
        TranslationServiceProvider::class,
        ValidationServiceProvider::class,
        ViewServiceProvider::class,
        NotificationServiceProvider::class,

        /*
         * Application Service Providers...
         */
        AppServiceProvider::class,
        EventServiceProvider::class,
        RouteServiceProvider::class,

        /*
         * External Service Providers
         */
        HtmlServiceProvider::class,
        MailServiceProvider::class,
        ServiceProvider::class,
        ImageServiceProvider::class,
        ReCaptchaServiceProvider::class,
        BarcodeServiceProvider::class,
        MarkdownServiceProvider::class,
        MollieServiceProvider::class,
        FeedsServiceProvider::class,
        HashidsServiceProvider::class,
        nickurt\PwnedPasswords\ServiceProvider::class,
        nickurt\PostcodeApi\ServiceProvider::class,
        Saml2ServiceProvider::class,
        Sentry\Laravel\ServiceProvider::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [

        'App' => App::class,
        'Artisan' => Artisan::class,
        'Auth' => Auth::class,
        'Blade' => Blade::class,
        'Bus' => Bus::class,
        'Cache' => Cache::class,
        'Config' => Config::class,
        'Cookie' => Cookie::class,
        'Crypt' => Crypt::class,
        'DB' => DB::class,
        'Eloquent' => Model::class,
        'File' => File::class,
        'Gate' => Gate::class,
        'Hash' => Hash::class,
        'Input' => Input::class,
        'Lang' => Lang::class,
        'Log' => Log::class,
        'Mail' => Mail::class,
        'Notification' => Notification::class,
        'Password' => Password::class,
        'Queue' => Queue::class,
        'Redirect' => Redirect::class,
        'Redis' => Redis::class,
        'Request' => Request::class,
        'Response' => Response::class,
        'Route' => Route::class,
        'Schema' => Schema::class,
        'Session' => Session::class,
        'Storage' => Storage::class,
        'URL' => URL::class,
        'Validator' => Validator::class,
        'View' => View::class,
        'Form' => FormFacade::class,
        'Html' => HtmlFacade::class,

        'Role' => Role::class,
        'Permission' => Permission::class,

        'Image' => Image::class,

        'PDF' => Html2Pdf::class,

        'DNS1D' => DNS1DFacade::class,
        'DNS2D' => DNS2DFacade::class,

        'Carbon' => Carbon::class,

        'Markdown' => Markdown::class,

        'ReCaptcha' => ReCaptcha::class,

        'Mollie' => Mollie::class,

        'Feeds' => FeedsFacade::class,

        'Hashids' => Hashids::class,

        'PwnedPasswords' => Facade::class,

        'Postcode' => nickurt\PostcodeApi\ServiceProvider::class,

    ],

];
