<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ACLController;

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

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
});

Route::controller(ACLController::class)->middleware('auth:api')->group(function () {
    Route::get('/records', 'index');
    Route::get('/records/create', 'create');
    Route::post('/records/store', 'store');
    Route::get('/records/edit/{id}', 'edit');
    Route::post('/records/update/{id}', 'update');
    Route::post('/records/delete/{id}', 'destroy');
});
