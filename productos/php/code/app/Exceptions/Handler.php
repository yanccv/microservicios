<?php

namespace App\Exceptions;

use App\Utilities\JsonResponseCustom;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Sentry\Laravel\Integration;

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
            Integration::captureUnhandledException($e);
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            return JsonResponseCustom::sendJson([
                'status' => false,
                'mensaje' => 'Registro no encontrado',
                'httpCode' => JsonResponseCustom::$CODE_NOT_FOUND
            ]);
        }

        if ($exception instanceof ValidationException) {
            return JsonResponseCustom::sendJson([
                'status' => false,
                'mensaje' => 'Fallo la validacion de la informacion',
                'error' => $exception->errors(),
                'httpCode' => JsonResponseCustom::$CODE_FAILED_VALIDATION
            ]);
        }
        return JsonResponseCustom::sendJson([
            'status' => false,
            'mensaje' => 'Error:'.$exception->getMessage(). ', File:'.$exception->getFile() . ', Line: '.$exception->getLine(),
            'httpCode' => JsonResponseCustom::$CODE_EXCEPTION
        ]);
    }
}
