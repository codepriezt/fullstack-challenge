<?php

namespace App\Exceptions;

use Throwable;
use Exception;
use PDOException;
use Illuminate\Http\Response;
use InvalidArgumentException;
use Illuminate\Validation\ValidationException;
use App\Traits\ResponseTrait as ResponseGenerator;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\Routing\Exception\InvalidParameterException;

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
            $error = null;
            $error = [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'stack' => $e->getTrace()
            ];
      
         if (parent::isHttpException($e)) {
             return match ($e->getStatusCode()) {
                 400 => ResponseGenerator::badRequest(null, $error),
                 401 => ResponseGenerator::unauthenticated(null, $error),
                 403 => ResponseGenerator::unauthorized(null, $error),
                 404 => ResponseGenerator::notfound(null, $error),
                 422 => ResponseGenerator::getResponse(Response::HTTP_UNPROCESSABLE_ENTITY, null, $error),
                 default => ResponseGenerator::error( null, $error),
             };
         }
         else if ($e instanceof ValidationException) {
             return ResponseGenerator::getResponse(
                                  Response::HTTP_UNPROCESSABLE_ENTITY,
                                   $e->validator->errors()->first(),
                                   $e->validator->errors());
         }
         else if ($e instanceof ModelNotFoundException) {
             return ResponseGenerator::getResponse(Response::HTTP_NOT_FOUND, null,$error);
         }
         else if ($e instanceof PDOException) {
             return ResponseGenerator::error(null , $error);
         }
         elseif ($e instanceof InvalidParameterException) {
             return ResponseGenerator::error($e, );
         }
         else if ($e instanceof InvalidArgumentException) {
             return ResponseGenerator::error(null, $e);
         }
         else if ($e instanceof Exception) {
             return ResponseGenerator::error(null, $error);
         }
         else {
             return ResponseGenerator::error(null, $error);
         }
        });
    }
}
