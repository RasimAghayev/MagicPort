<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route ;


Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\V1'], function () {
    Route::apiResource('companies', 'Company\CompanyController');
});



Route::fallback(function () {
    if (request()->wantsJson()) {
        return response()->json([
            'error' => 'Resources not found.',
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
