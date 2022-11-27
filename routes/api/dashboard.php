<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Dashboard\ProductController;

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
| Product
|--------------------------------------------------------------------------
*/

Route::group(
    [
        'as' => 'api.product.',
        'middleware' => ['auth:sanctum'],
        'prefix' => 'product',
    ],
    function () {
        Route::get('', [ProductController::class, 'index'])
            ->name('index');

        Route::get('show', [ProductController::class, 'show'])
            ->name('show');

        Route::post('store', [ProductController::class, 'store'])
            ->name('store');

        Route::post('update', [ProductController::class, 'update'])
            ->name('update');

        Route::delete('{id}', [ProductController::class, 'destroy'])
            ->name('destroy');
    }
);
