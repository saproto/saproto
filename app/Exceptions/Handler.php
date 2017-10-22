<?php

namespace Proto\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Intervention\Image\Exception\NotReadableException;
use Illuminate\Session\TokenMismatchException;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;

use App;
use Auth;

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
        AuthorizationException::class
    ];

    private $sentryID;

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     * @return void
     */
    public function report(Exception $e)
    {

        if ($this->shouldReport($e) && App::environment('production')) {

            $sentry = app('sentry');

            $context = null;

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

                $context = [
                    'id' => $user->id,
                    'is_member' => $user->member != null,
                    'roles' => $roles,
                    'committees' => $committees
                ];

            }

            $sentry->user_context([
                'user' => $context
            ]);

            $this->sentryID = $sentry->captureException($e);

        } else {
            return parent::report($e);
        }

    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {

        $reported = true;
        $message = "Something is wrong with the website.";
        $statuscode = 500;

        if ($e instanceof HttpException) {
            $reported = false;
            $message = $e->getMessage();
            $statuscode = $e->getStatusCode();
        } elseif ($e instanceof NotFoundHttpException) {
            $reported = false;
            $message = "The page you requested does not exist.";
            $statuscode = 404;
        } elseif ($e instanceof ModelNotFoundException) {
            $reported = false;
            $message = "You requested an database entry that does not exist.";
            $statuscode = 404;
        } elseif ($e instanceof NotReadableException) {
            $reported = false;
            $message = "Unable to read the requested file from disk.";
            $statuscode = 500;
        } elseif ($e instanceof TokenMismatchException) {
            $reported = false;
            $message = "Token does not match. O behave, you cross-site scripter!";
            $statuscode = 403;
        }

        if ($statuscode == 503) {
            return response()->view('errors.503');
        }

        if (App::environment('production')) {

            return response()->view('errors.generic', [
                'reported' => $reported,
                'message' => $message,
                'statuscode' => $statuscode,
                'sentryID' => $this->sentryID
            ], $statuscode);

        } else {
            return parent::render($request, $e);
        }

    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Illuminate\Auth\AuthenticationException $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }

}
