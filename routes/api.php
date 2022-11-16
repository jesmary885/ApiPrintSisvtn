<?php

use App\Http\Controllers\PrintController;
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

Route::post('login', [App\Http\Controllers\Api\LoginController::class, 'login']);

Route::get('print_ticket/{data}',[App\Http\Controllers\Api\PrintController::class, 'print_ticket']);
Route::get('print_nota/{data}',[App\Http\Controllers\Api\PrintController::class, 'print_nota']);
Route::get('print_reportex/{data}/{data2}/{data4}/{data3}',[App\Http\Controllers\Api\PrintController::class, 'print_reportex']);
