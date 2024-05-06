<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\studentController;

Route::post('students/register', [studentController::class, 'register']);
Route::post('students/login', [studentController::class, 'login'])->name('login');
Route::get('students', [studentController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('students/{id}', [studentController::class, 'show']);
    Route::put('students/{id}', [studentController::class, 'update']);
    Route::patch('students/{id}', [studentController::class, 'updatePartial']);
    Route::delete('students/{id}', [studentController::class, 'destroy']);
});
