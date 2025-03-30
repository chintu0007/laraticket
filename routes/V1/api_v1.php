<?php

use App\Http\Controllers\Api\V1\TicketController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\Ticket;

Route::prefix('v1')->middleware('auth:sanctum')->group(function() {
    Route::apiResource('tickets', TicketController::class);
    Route::apiResource('users', UserController::class);
});

