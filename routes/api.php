<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherAssignmentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\GradeController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

// Authentication
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [LoginController::class, 'register']);

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (SANCTUM)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // =========================================
    // AUTH
    // =========================================
    Route::post('/logout', [LoginController::class, 'logout']);

    Route::get('/me', function (\Illuminate\Http\Request $request) {
        return response()->json($request->user());
    });

    // =========================================
    // USERS
    // =========================================
    Route::get('/users', [LoginController::class, 'fetchAllUsers']);

    Route::put('/users/{id}', [LoginController::class, 'updateUser']);

    Route::put('/users/{id}/deactivate', [LoginController::class, 'deactivateUser']);

    Route::put('/users/{id}/activate', [LoginController::class, 'activateUser']);

    Route::get('/FetchTeacherUsernames', [LoginController::class, 'fetchTeacherUsernames']);

    // =========================================
    // SUBJECTS
    // =========================================
    Route::get('/subjects', [SubjectController::class, 'index']);

    Route::post('/subjects', [SubjectController::class, 'store']);

    Route::put('/subjects/{id}', [SubjectController::class, 'update']);

    Route::delete('/subjects/{id}', [SubjectController::class, 'destroy']);

    // =========================================
    // SECTIONS
    // =========================================
    Route::get('/sections', [SectionController::class, 'index']);

    Route::post('/sections/create', [SectionController::class, 'store']);

    Route::get('/sections/{id}', [SectionController::class, 'show']);

    Route::put('/sections/{id}/update', [SectionController::class, 'update']);

    Route::delete('/sections/{id}/delete', [SectionController::class, 'destroy']);

    Route::post('/sections/{id}/assign-teacher',
        [SectionController::class, 'assignTeacher']
    );

    // =========================================
    // TEACHER ASSIGNMENTS
    // =========================================
    Route::get('/assignments', [TeacherAssignmentController::class, 'index']);

    Route::post('/assignments', [TeacherAssignmentController::class, 'store']);

    Route::put('/assignments/{id}', [TeacherAssignmentController::class, 'update']);

    Route::delete('/assignments/{id}', [TeacherAssignmentController::class, 'destroy']);

    // =========================================
    // STUDENTS
    // =========================================
    Route::post('/sections/bulk-import-students',
        [SectionController::class, 'bulkImportStudents']
    );

    Route::get('/students', [StudentController::class, 'index']);

    Route::get('/sections/{id}/students',
        [StudentController::class, 'getStudents']
    );

    Route::post('/students/create', [StudentController::class, 'store']);

    Route::put('/students/{id}/update', [StudentController::class, 'update']);

    Route::delete('/students/{id}/delete', [StudentController::class, 'destroy']);

    Route::get('/total-students', [StudentController::class, 'totalStudents']);

    // =========================================
    // GRADES
    // =========================================
    Route::post('/grades/import', [GradeController::class, 'import']);

    Route::get('/grades', [GradeController::class, 'index']);

    Route::post('/grades/bulk-store', [GradeController::class, 'bulkStore']);

});