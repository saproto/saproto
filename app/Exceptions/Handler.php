<?php

namespace Proto\Exceptions;

use App;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Exception\NotReadableException;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        NotFoundHttpException::class,
        ModelNotFoundException::class,
        TokenMismatchException::class,
        HttpException::class,
        NotReadableException::class,
        ValidationException::class,
        AuthorizationException::class,
    ];

    private $sentryID;

    /**
     * Report or log an exception.
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param Exception $e
     * @return void
     * @throws Exception
     */
    public function report(Exception $e)
    {
        if (app()->bound('sentry') && $this->shouldReport($e) && App::environment('production')) {
            $sentry = app('sentry');
            $this->sentryID = $sentry->captureException($e);
        }

        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request $request
     * @param  Exception $e
     * @return Response
     */
    public function render($request, Exception $e)
    {
        return parent::render($request, $e);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  Request $request
     * @param  AuthenticationException $exception
     * @return JsonResponse|RedirectResponse
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }

    /**
     * Render the given HttpException.
     *
     * @param  HttpException $e
     * @return SymfonyResponse
     */
    protected function renderHttpException(HttpException $e)
    {
        if (! view()->exists("errors.{$e->getStatusCode()}")) {
            return response()->view('errors.default', ['exception' => $e], 500, $e->getHeaders());
        }
        return parent::renderHttpException($e);
    }
}
