<?php

use App\Http\Controllers\Api\V1\AuthorTicketController;
use App\Http\Controllers\Api\V1\TicketController;
use App\Http\Controllers\Api\V1\AuthorsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\Ticket;

Route::prefix('v1')->middleware('auth:sanctum')->group(function() {
    Route::apiResource('tickets', TicketController::class)->except(['update']);
    Route::put('tickets/{ticket}', [TicketController::class, 'replace']);
    Route::patch('tickets/{ticket}', [TicketController::class, 'update']);

    Route::apiResource('authors', AuthorsController::class);

    Route::apiResource('authors.tickets', AuthorTicketController::class)->except(['update']);
    Route::put('authors/{author}/tickets/{ticket}', [AuthorTicketController::class, 'replace']);
    Route::patch('authors/{author}/tickets/{ticket}', [AuthorTicketController::class, 'update']);
    
});

