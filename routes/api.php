<?php

use App\Http\Controllers\Api\FCustomerController;
use App\Http\Controllers\Api\FFiscYearController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::controller(UserController::class)->group(function () {
    Route::post('login', 'login');
});
Route::prefix('v1/rest')->group(function () {
    Route::group(['middleware' => ['auth:sanctum']], function () {
        // customer
        Route::controller(FCustomerController::class)->group(function () {
            Route::get('customers/search/{page?}', 'search');
            Route::post('customers/create', 'store');
            Route::get('customers/fetch/{id}', 'edit');
            Route::post('customers/update/{id}', 'update');
        });
        Route::controller(FFiscYearController::class)->group(function () {
            Route::get('f-fisc_year/search/{page?}', 'search');
            Route::post('f-fisc_year/create', 'store');
            Route::get('f-fisc_year/fetch/{id}', 'edit');
            Route::post('f-fisc_year/update/{id}', 'update');
        });

    });
});
