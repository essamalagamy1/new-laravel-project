<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class ApiExceptionHandlerException extends ExceptionHandler
{
    public function register(): void
    {
        if (request()->is('api/*')) {
            $this->renderable(function (NotFoundHttpException $e, $request) {
                return Response::notFound();
            });

            $this->renderable(function (UnauthorizedHttpException $e, $request) {
                return Response::unauthorized();
            });

            $this->renderable(function (AccessDeniedHttpException $e, $request) {
                return Response::forbidden();
            });

            $this->renderable(function (AuthenticationException $e, $request) {
                return Response::unauthenticated();
            });

            $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
                return Response::methodNotAllowed();
            });

            //			$this->renderable(function (\Exception $e, $request) {
            //				return Response::internalError();
            //			});
        }

    }
}
