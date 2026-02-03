<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Square1\LaravelIdempotency\Exceptions\MissingIdempotencyKeyException;
use Square1\LaravelIdempotency\Exceptions\MismatchedPathException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
		$middleware->alias([
			'idempotency' => \Square1\LaravelIdempotency\Http\Middleware\IdempotencyMiddleware::class,
		]);
	})
    ->withExceptions(function (Exceptions $exceptions): void {		
		$exceptions->render(function (MissingIdempotencyKeyException $e, Request $request) {			
			return response()->json(['error' => $e->getMessage()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY, [], JSON_UNESCAPED_UNICODE);			
		});
		
		$exceptions->render(function (MismatchedPathException $e, Request $request) {			
			return response()->json(['error' => $e->getMessage()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY, [], JSON_UNESCAPED_UNICODE);			
		});
		
		$exceptions->render(function (NotFoundHttpException $e, Request $request) {
			if ($request->is('api/*')) {
				return response()->json(['error' => 'Record not found.'], 404, [], JSON_UNESCAPED_UNICODE);			
			}
		});
		
		$exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
			if ($request->is('api/*')) {
				return response()->json(['error' => $e->getMessage()], 404, [], JSON_UNESCAPED_UNICODE);			
			}
		});
		
    })->create();
