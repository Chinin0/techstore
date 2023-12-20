<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BlogController;
use App\Http\Controllers\PagoController;

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
Route::get('/blogs', [BlogController::class, 'index_api']);
Route::get('/blogs/{id}', [BlogController::class, 'show_api']);
Route::post('/blogs', [BlogController::class, 'store_api']);
Route::put('/blogs/{id}', [BlogController::class, 'update_api']);
Route::delete('/blogs/{id}', [BlogController::class, 'destroy_api']);

Route::post('/confirmarPago',[PagoController::class, 'confirmarPago']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
