<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\RepairProposalController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ComplainController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('cars', CarController::class);

    Route::apiResource('repair-proposals', RepairProposalController::class);
    Route::put('/repair-proposals/accept/{repair_proposal}', [RepairProposalController::class, 'accept']);

    Route::get('/services', [ServiceController::class, 'index']);
    Route::put('/services/done/{service}', [ServiceController::class, 'done']);

    Route::get('/complains', [ComplainController::class, 'index']);
    Route::post('/complains', [ComplainController::class, 'store']);
});