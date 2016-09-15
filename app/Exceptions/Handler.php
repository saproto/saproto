<?php

namespace Proto\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
        ModelNotFoundException::class
    ];

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

        if (App::environment('production')) {
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

            $sentry->captureException($e);
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

        if ($e instanceof NotFoundHttpException) {
            $reported = false;
            $message = "The page you requested does not exist.";
            $statuscode = 404;
        } elseif ($e instanceof ModelNotFoundException) {
            $reported = false;
            $message = "You requested an database entry that does not exist.";
            $statuscode = 404;
        } elseif ($e instanceof HttpException) {
            $reported = false;
            $message = $e->getMessage();
            $statuscode = $e->getStatusCode();
        }


        if (App::environment('production')) {

            return response()->view('errors.generic', [
                'reported' => $reported,
                'message' => $message,
                'statuscode' => $statuscode
            ], $statuscode);

        } else {
            return parent::render($request, $e);
        }

    }
}
