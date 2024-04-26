<?php

namespace App\Exceptions;

use App\Http\Resources\ApiResponse;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{

    protected $levels = [
        //
    ];


    protected $dontReport = [
        //
    ];


    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function render($request, $exception)
    {
        $response = $this->handleException($request, $exception);
        return $response;
    }



    public function handleException($request, $exception)
    {
        $statusCode = 500;
        $message = "Terjadi kesalahan!";
        $data = null;

        if ($exception instanceof ApiException) {
            $statusCode = $exception->getStatusCode();
            $message = $exception->getMessage();
            $data = $exception->getData();
        } elseif ($exception instanceof QueryException && $exception->errorInfo[1] == 1062) {
            $statusCode = 400;
            $message = "Username telah terpakai. Gunakan yang lain!";
        }

        if (config('app.debug')) {
            return parent::render($request, $exception);
        }

        return new ApiResponse($statusCode, $message, $data);
    }

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
    }
}
