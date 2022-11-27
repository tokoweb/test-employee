<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

        // Handle Error Unauthenticated
        $this->renderable(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            $response = [
                'status' => false,
                'message' => 'Belum authentikasi !',
                'data' => null,
                'pagination' => null,
                'errors' => null,
            ];

            if ($request->is('api/*')) {
                return response()->json($response, 401);
            }
        });

        $this->renderable(function (Throwable $e, $request) {
            // Handle Error Route Not Found
            if ($request->expectsJson()) {
                if ($e instanceof NotFoundHttpException) {
                    $response = [
                        'status' => false,
                        'message' => 'URL tidak ditemukan !',
                        'data' => null,
                        'pagination' => null,
                        'errors' => null,
                    ];

                    return response($response, 404);
                }
            }

            // Handle Error Custom
            if ($request->is('api/*')) {
                if ($e instanceof HttpExceptionInterface) {
                    $response = [
                        'status' => false,
                        'message' => $e->getMessage(),
                        'data' => null,
                        'pagination' => null,
                        'errors' => null,
                    ];

                    if (config('app.debug')) {
                        $debug = [
                            'exception' => get_class($e),
                            'file' => $e->getFile(),
                            'trace' => $e->getTrace(),
                        ];

                        $response = array_merge($response, $debug);
                    }

                    if ($e->getStatusCode() === 429) {
                        $retry = $e->getHeaders()['Retry-After'];
                        $response['message'] = 'Try again in ' . $retry . ' seconds';
                    }

                    return response()->json($response, $e->getStatusCode());
                } else if ($e instanceof ValidationException) {
                    $error = $e->errors();
                    $field = array_key_first($error);
                    $message = collect($e->errors())->first()[0];

                    if (count($e->errors()) > 0) {
                        $error = (object) [
                            $field => $message
                        ];
                    } else {
                        $error = null;
                    }

                    $response = [
                        'status' => false,
                        'message' => $message,
                        'data' => null,
                        'pagination' => null,
                        'errors' => $error,
                    ];

                    return response()->json($response, $e->status);
                }
            }
        });
    }
}
