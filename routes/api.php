<?php

use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\RegisterController;
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

Route::post('/login', [LoginController::class, 'store']);
Route::post('/register', RegisterController::class);

Route::middleware('auth:api')
    ->group(function () {
        Route::delete('/logout', [LoginController::class, 'destroy']);

        Route::get('/user', function (Request $request) {
            return $request->user();
        });
    });
