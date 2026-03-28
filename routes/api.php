<?php

// routes/api.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SectionController;

// APIfor sections
Route::get('/sections', [SectionController::class, 'index']);
Route::post('/sections/create', [SectionController::class, 'store']);
Route::get('/sections/{id}', [SectionController::class, 'show']);
Route::put('/sections/{id}/update', [SectionController::class, 'update']);
Route::delete('/sections/{id}/delete', [SectionController::class, 'destroy']);
Route::post('/sections/{id}/assign-teacher', [SectionController::class, 'assignTeacher'])->middleware('auth:sanctum');



// Authentication routes
Route::get('/FetchTeacherUsernames', [LoginController::class, 'fetchTeacherUsernames']);
Route::post('/register', [LoginController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);



