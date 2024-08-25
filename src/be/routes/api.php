<?php

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route ;
use Illuminate\Http\Request;
use App\Models\User;

Route::get('/users', function (Request $request) {
    return $request->user();
})->middleware(Authenticate::using('sanctum'));
