<?php

namespace Proto\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Intervention\Image\Exception\NotReadableException;
use Illuminate\Session\TokenMismatchException;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;

use Illuminate\Auth\AuthenticationException;

use App;
use Auth;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpExceptionInterface::class,
        NotFoundHttpException::class,
        ModelNotFoundException::class,
        TokenMismatchException::class,
        HttpExceptionInterface::class,
        NotReadableException::class,
        ValidationException::class,
        AuthorizationException::class
    ];

    private $sentryID;

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param Throwable $e
     * @return void
     * @throws Throwable
     */
    public function report(Throwable $e)
    {

        if (app()->bound('sentry') && $this->shouldReport($e) && App::environment('production')) {

            $sentry = app('sentry');

            if (Auth::check()) {

                $user = Auth::user();

                $committees = [];
                foreach ($user->committees as $committee) {
                    $committees[] = $committee->slug;
                }

                $roles = [];
                foreach ($user->roles as $role) {
                    $roles[] = $role->name;
                }

            }

            $this->sentryID = $sentry->captureException($e);

        } else {
            return parent::report($e);
        }

        parent::report($e);

    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param Throwable $e
     * @return \Illuminate\Http\Response
     * @throws Throwable
     */
    public function render($request, Throwable $e)
    {

        return parent::render($request, $e);

    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Illuminate\Auth\AuthenticationException $exception
     * @return \Illuminate\Http\JsonResponse| \Illuminate\Http\RedirectResponse
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
     * @param HttpExceptionInterface $e
     * @return Response
     */
    protected function renderHttpException(HttpExceptionInterface $e)
    {
        if (!view()->exists("errors.{$e->getStatusCode()}")) {
            return response()->view('errors.default', ['exception' => $e], 500, $e->getHeaders());
        }
        return parent::renderHttpException($e);
    }


}
