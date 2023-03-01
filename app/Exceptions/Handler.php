<?php

namespace App\Exceptions;

use App\Facades\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        /**
         * 自定义 Guard 身份认证失败异常消息
         */
        $this->renderable(function (AuthenticationException $e) {
            return Response::failed(
                40109, 
                $e->getMessage()
            )->setStatusCode(401)->toJson();
        });

        /**
         * 自定义表单验证器异常消息
         */
        $this->renderable(function (ValidationException $e) {
            return Response::failed(
                10009, 
                $e->validator->getMessageBag()->first(),
            )->toJson();
        });
    }
}
