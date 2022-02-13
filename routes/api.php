<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'v1/'], function () {

    Route::get('', function () {
        return response()->json([
            'message' => 'Welcome to the API',
            'status' => 'success',
            'code' => 200
        ]);
    });

    Route::post('register', [App\Http\Controllers\Api\PassportAuthController::class, 'register']);
    Route::post('login', [App\Http\Controllers\Api\PassportAuthController::class, 'login']);

    Route::group(['middleware' => ['auth_token']], function () {
        Route::get('get-user', [App\Http\Controllers\Api\PassportAuthController::class, 'userInfo']);

        Route::resource('products', App\Http\Controllers\Api\ProductController::class);
    });
});


Route::fallback(function () {
    return \Response::json(
        [
            'data' => [
                'message' => 'Not Found.',
                'status_code' => 404
            ]
        ],
        404
    );
})->name('api.fallback.404');
