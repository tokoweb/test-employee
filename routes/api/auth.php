<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Auth\LoginController;

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

/*
|--------------------------------------------------------------------------
| Login
|--------------------------------------------------------------------------
*/

Route::group(
    [
        'as' => 'api.login.',
    ],
    function () {
        Route::post('login', [LoginController::class, 'index'])
            ->name('index');

        Route::post('logout', [LoginController::class, 'logout'])
            ->middleware(['auth:sanctum'])
            ->name('logout');
    }
);
