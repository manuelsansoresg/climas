<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;

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

Route::get('/clients/search', [App\Http\Controllers\Admin\ClientController::class, 'search']);

Route::get('/products/search', [ProductController::class, 'search']);

Route::post('/admin-unlock-key/validate', [\App\Http\Controllers\Api\AdminUnlockKeyController::class, 'validateKey']);
