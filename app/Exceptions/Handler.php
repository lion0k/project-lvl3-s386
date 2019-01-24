<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            return response(view("errors.404"), Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof ValidationException) {
            $error[] = $exception->getMessage();

            $getDataFromRequest = function ($key, $default = '') use ($request) {
                return ($request->has($key)) ? $request->get($key) : $default;
            };

            $oldName = $getDataFromRequest('oldName');
            $name = $getDataFromRequest('name');
            $info = ', use for example http://example.com';
            if (empty($name)) {
                $error[] = "URL is empty{$info}";
            } else {
                $error[] = "This URL <b>{$oldName}</b> is not correct{$info}";
            }

            return response(view("index", [
                'errors' => $error,
                'oldName' => $oldName,
                'name' => $name]), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

//        if ($exception instanceof \Throwable) {
//            $error[] = $exception->getMessage();
//            return response(view("index", ['errors' => $error]), Response::HTTP_INTERNAL_SERVER_ERROR);
//        }

        if (env('APP_DEBUG', false)) {
            return parent::render($request, $exception);
        }

        return response(view("errors.500"), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
