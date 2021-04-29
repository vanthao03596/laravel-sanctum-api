<?php

use App\Http\Controllers\API\AuthController;
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

Route::post('/login', [AuthController::class, 'store']);

Route::middleware('auth:api')
    ->group(function () {
        Route::delete('/logout', [AuthController::class, 'destroy']);

        Route::get('/user', function (Request $request) {
            return $request->user();
        });
    });
