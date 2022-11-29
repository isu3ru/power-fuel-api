<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// mobile app api routes
Route::prefix('mobile-api')->group(function () {
    Route::middleware('auth:sanctum')->group(
        function () {
            // mobile-api/user
            Route::get('/user', function (Request $request) {
                return $request->user();
            });

            // mobile-api/logout
            Route::post('/logout', function (Request $request) {
                $request->user()->tokens()->delete();

                return response()->json(['message' => 'Successfully logged out']);
            });
        }
    ); // end group:sanctum-auth
}); // end prefix:mobile-api

// web api routes
Route::prefix('web-api')->group(function () {
    // web api routes for administration panel
}); // end prefix:web-api
