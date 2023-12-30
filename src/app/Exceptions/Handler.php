<?php

namespace Starmoozie\LaravelAccess\app\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\{
    Eloquent\ModelNotFoundException,
    QueryException
};
use Symfony\Component\HttpKernel\Exception\{
    MethodNotAllowedHttpException,
    NotFoundHttpException
};
use Starmoozie\LaravelAccess\app\{
    Traits\HttpResponse,
    Enums\HttpCode
};

class Handler extends ExceptionHandler
{
    use HttpResponse;

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        // Handle http not found exceptions
        $this->renderable(fn (NotFoundHttpException $e, $request) => $this->failedMessage($e->getMessage(), HttpCode::NOT_FOUND));

        // Handle method not allowed responses.
        $this->renderable(fn (MethodNotAllowedHttpException $exception) => $this->failedMessage(__('laravel-access-trans::message.not_found'), HttpCode::NOT_FOUND));

        // Handle query column not found responses.
        $this->renderable(fn (QueryException $exception, $request) => $this->failedMessage($exception->getPrevious()->getMessage(), HttpCode::FAILED));
    }

    /**
     * Handle if user unauthenticated.
     * @param  \Illuminate\Http\Request  $request
     * @param AuthenticationException  $exception
     * 
     * @return redirect|response
     *
     * @return void
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $request->expectsJson()
            ? $this->failedMessage($exception->getMessage(),)
            : redirect()->guest(route('login'));
    }
}
