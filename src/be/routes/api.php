<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="MagicPort API",
 *     version="1.0.0",
 *     description="MagicPort Laravel backend API — company, project, task, user management with Sanctum auth and RBAC.",
 *     @OA\Contact(email="support@magicport.example"),
 *     @OA\License(name="MIT", url="https://opensource.org/licenses/MIT")
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="API Server"
 * )
 *
 * @OA\SecurityScheme(
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="sanctum",
 *     description="Sanctum API token"
 * )
 */

Route::group([
    'prefix' => 'v1',
    'namespace' => 'App\Http\Controllers',
    'middleware' => ['auth:sanctum'],
], function () {
    Route::apiResource('companies', CompanyController::class);
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('tasks', TaskController::class);
    Route::apiResource('users', UserController::class);

    Route::post('companies/{code}/restore', [CompanyController::class, 'restore']);
    Route::delete('companies/{code}/force-delete', [CompanyController::class, 'forceDelete']);
    Route::post('projects/{code}/restore', [ProjectController::class, 'restore']);
    Route::delete('projects/{code}/force-delete', [ProjectController::class, 'forceDelete']);
    Route::post('tasks/{code}/restore', [TaskController::class, 'restore']);
    Route::delete('tasks/{code}/force-delete', [TaskController::class, 'forceDelete']);
    Route::post('users/{id}/restore', [UserController::class, 'restore']);
    Route::delete('users/{id}/force-delete', [UserController::class, 'forceDelete']);

    Route::apiResource('audit-logs', AuditLogController::class)->only(['index', 'show']);

    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login'])->middleware('guest');
        Route::post('register', [AuthController::class, 'register'])->middleware('guest');
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
    });
});

Route::fallback(function () {
    if (request()->wantsJson()) {
        return response()->json([
            'error' => 'Resource not found.',
            'message' => 'The resource you are looking for could not be found.'
        ], 404);
    }

    return response()->view('errors.404', [], 404);
});

Route::group(['prefix' => 'check'], function () {
    Route::get('/db', function () {
        try {
            DB::connection()->getPdo();
            return response('Application is up and running, database connection is ok!', 200);
        } catch (\Exception $e) {
            return response('Failed to connect to the database', 500);
        }
    });
    Route::get('/health', function () {
        return response('', 204);
    });
    Route::get('/static', function () {
        return response()->json([
            'status' => true,
        ]);
    });
    Route::get('/ip', function () {
        return Http::get('https://ipapi.co/json/')->json();
    });
    Route::get('/clear-cache', function() {
        Artisan::call('optimize:clear');
        Artisan::call('config:cache');
        Artisan::call('config:clear');
        Artisan::call('clear-compiled');
        Artisan::call('cache:clear');
        Artisan::call('route:cache');
        Artisan::call('view:clear');
        return "Cache is cleared ".date(now());
    });
});
