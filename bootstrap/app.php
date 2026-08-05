<?php

use App\Http\Middleware\AdminLog;
use App\Http\Middleware\AdminLogged;
use App\Http\Middleware\AuthenticatedUser;
use App\Http\Middleware\ForceJsonResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api(prepend: [
            ForceJsonResponse::class,
        ]);
       $middleware->alias([
            'admin.logged_in'=> AdminLog::class,
            'admin.logged_out'=> AdminLogged::class,
            'check.user'=>AuthenticatedUser::class,
            'b2b.approved' => \App\Http\Middleware\B2BApproved::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            // '/dashboard/payment/*',
            // 'api/webhook/payment'
			// 'http://example.com/foo/bar',
			// 'http://example.com/foo/*',
		]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // 1. Handle HTTP Method Not Allowed (405)
        // $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
        //     if ($request->is('api/*') || $request->wantsJson()) {
        //         return response()->json([
        //             'status' => false,
        //             'error_code' => 'METHOD_NOT_ALLOWED',
        //             'message' => 'The requested HTTP method is not supported for this endpoint.',
        //             'allowed_methods' => $e->getHeaders()['Allow'] ?? [],
        //         ], 405);
        //     }
        // });

        // 2. Handle Route or Resource Not Found (404)
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json([
                    'status' => false,
                    'error_code' => 'RESOURCE_NOT_FOUND',
                    'message' => 'The requested endpoint or resource was not found.',
                ], 404);
            }
        });

        // 3. Handle Unauthenticated Requests (401)
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json([
                    'status' => false,
                    'error_code' => 'UNAUTHENTICATED',
                    'message' => 'Unauthenticated or invalid API token provided.',
                ], 401);
            }
        });

        // 4. Handle Form Validation Errors (422)
        $exceptions->render(function (ValidationException $e, Request $request) {
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json([
                    'status' => false,
                    'error_code' => 'VALIDATION_ERROR',
                    'message' => 'The given data was invalid.',
                    'errors' => $e->errors(),
                ], 422);
            }
        });

        // 5. Catch-All for Unhandled Server Errors (500)
        // $exceptions->render(function (\Throwable $e, Request $request) {
        //     if ($request->is('api/*') || $request->wantsJson()) {
        //         return response()->json([
        //             'status' => false,
        //             'error_code' => 'SERVER_ERROR',
        //             'message' => app()->environment('local') ? $e->getMessage() : 'An unexpected server error occurred.',
        //         ], 500);
        //     }
        // });

        // User-Friendly 405 Method Not Allowed Response
        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            if ($request->is('api/*') || $request->wantsJson()) {
                
                // Get allowed methods (e.g., ["GET", "HEAD"])
                $allowedMethods = $e->getHeaders()['Allow'] ?? 'GET';
                $supportedMethods = explode(', ', $allowedMethods);
                $usedMethod = $request->method();

                return response()->json([
                    'success' => false,
                    'message' => "Invalid request method. You sent a {$usedMethod} request, but this endpoint expects a " . implode(' or ', $supportedMethods) . " request.",
                     
                ], 405);
            }
        });
    })
    ->create();
