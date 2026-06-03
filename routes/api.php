<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KashierController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Webhook من Kashier (بدون CSRF)
Route::post('/kashier/webhook', [KashierController::class, 'webhook'])
    ->name('kashier.webhook')
    ->withoutMiddleware('csrf');
