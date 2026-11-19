<?php

use App\Http\Controllers\V1\Auth\AuthController;
use App\Http\Controllers\V1\Company\CompanyController;
use App\Http\Controllers\V1\Contract\ContractController;
use App\Http\Controllers\V1\Invoice\InvoiceController;
use App\Http\Controllers\V1\Project\ProjectController;
use App\Http\Controllers\V1\Task\TaskController;
use App\Http\Controllers\V1\Ticket\TicketController;
use App\Http\Controllers\V1\User\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
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

// Public auth routes
Route::prefix('v1/auth')->group(function () {
    Route::post('login', [AuthController::class, 'login'])
        ->name('auth.login');
    Route::post('register', [AuthController::class, 'register'])
        ->name('auth.register');

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
        Route::get('me', [AuthController::class, 'me'])->name('auth.me');
    });
});

// Protected API routes
Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::get('audit-logs', [\App\Http\Controllers\AuditLogController::class, 'index'])->name('audit-logs.index');
    Route::get('audit-logs/{id}', [\App\Http\Controllers\AuditLogController::class, 'show'])->name('audit-logs.show');

    Route::apiResource('companies', CompanyController::class)
        ->only(['index', 'store', 'show', 'update', 'destroy']);

    Route::post('companies/{code}/restore', [CompanyController::class, 'restore'])
        ->name('companies.restore');
    Route::delete('companies/{code}/force-delete', [CompanyController::class, 'forceDelete'])
        ->name('companies.force-delete');

    Route::apiResource('projects', ProjectController::class)
        ->only(['index', 'store', 'show', 'update', 'destroy']);

    Route::post('projects/{code}/restore', [ProjectController::class, 'restore'])
        ->name('projects.restore');
    Route::delete('projects/{code}/force-delete', [ProjectController::class, 'forceDelete'])
        ->name('projects.force-delete');

    Route::apiResource('tasks', TaskController::class)
        ->only(['index', 'store', 'show', 'update', 'destroy']);

    Route::post('tasks/{code}/restore', [TaskController::class, 'restore'])
        ->name('tasks.restore');
    Route::delete('tasks/{code}/force-delete', [TaskController::class, 'forceDelete'])
        ->name('tasks.force-delete');

    Route::apiResource('users', UserController::class)
        ->only(['index', 'store', 'show', 'update', 'destroy']);

    Route::post('users/{id}/restore', [UserController::class, 'restore'])
        ->name('users.restore');
    Route::delete('users/{id}/force-delete', [UserController::class, 'forceDelete'])
        ->name('users.force-delete');

    Route::apiResource('invoices', InvoiceController::class)
        ->only(['index', 'store', 'show', 'update', 'destroy']);

    Route::post('invoices/{code}/restore', [InvoiceController::class, 'restore'])
        ->name('invoices.restore');
    Route::delete('invoices/{code}/force-delete', [InvoiceController::class, 'forceDelete'])
        ->name('invoices.force-delete');

    Route::apiResource('contracts', ContractController::class)
        ->only(['index', 'store', 'show', 'update', 'destroy']);

    Route::post('contracts/{code}/restore', [ContractController::class, 'restore'])
        ->name('contracts.restore');
    Route::delete('contracts/{code}/force-delete', [ContractController::class, 'forceDelete'])
        ->name('contracts.force-delete');

    Route::apiResource('tickets', TicketController::class)
        ->only(['index', 'store', 'show', 'update', 'destroy']);

    Route::post('tickets/{code}/restore', [TicketController::class, 'restore'])
        ->name('tickets.restore');
    Route::delete('tickets/{code}/force-delete', [TicketController::class, 'forceDelete'])
        ->name('tickets.force-delete');
});

// Health endpoints
Route::prefix('check')->group(function () {
    Route::get('/health', function () {
        return response('', 204);
    });

    Route::get('/db', function () {
        try {
            DB::connection()->getPdo();
            return response('Application is up and running, database connection is ok!', 200);
        } catch (\Exception $e) {
            return response('Failed to connect to the database', 500);
        }
    });

    Route::get('/static', function () {
        return response()->json(['status' => true]);
    });
});

Route::fallback(function () {
    if (request()->wantsJson()) {
        return response()->json([
            'success' => false,
            'message' => 'Resource not found.',
            'errors' => ['route' => ['The requested route could not be found.']],
        ], 404);
    }

    return response()->view('errors.404', [], 404);
});
