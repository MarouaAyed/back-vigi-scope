<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckEmailController;
use App\Http\Controllers\ClassificationController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\UserController;
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

Route::get('/authorize', [CheckEmailController::class, 'authorizeUser']);
Route::get('/callback', [CheckEmailController::class, 'handleCallback']);
Route::get('/emails', [CheckEmailController::class, 'fetchEmails']);

Route::resource('/appointments', AppointmentController::class);

Route::post('/affect-email', [EmailController::class, 'affect_email']);
Route::get('/emails-affected', [EmailController::class, 'emails_affected']);
Route::get('/all-emails', [EmailController::class, 'index']);

Route::get('/classifications', [ClassificationController::class, 'index']);

Route::get('/users', [UserController::class, 'index']);
Route::get('/managers', [UserController::class, 'get_managers']);