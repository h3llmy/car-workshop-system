<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\RepairProposalController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('cars', CarController::class);

    Route::apiResource('repair-proposals', RepairProposalController::class);
    Route::put('/repair-proposals/accept/{repair_proposal}', [RepairProposalController::class, 'accept']);
    Route::put('/repair-proposals/done/{repair_proposal}', [RepairProposalController::class, 'done']);
});