<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OutlookEmailController;
use App\Http\Controllers\VerificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user(); 
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/redirectToMicrosoft', [AuthController::class, 'redirectToMicrosoft']);

Route::get('/authorize', [OutlookEmailController::class, 'authorizeUser']);
Route::get('/callback', [OutlookEmailController::class, 'handleCallback']);
Route::get('/emails', [OutlookEmailController::class, 'fetchEmails']);

Route::resource('/appointments', AppointmentController::class);