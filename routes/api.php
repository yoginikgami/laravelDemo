<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthenticatedSessionController::class, 'apilogin']);
Route::post('/logout', [AuthenticatedSessionController::class, 'apilogout'])->middleware('auth:sanctum');




Route::middleware('auth:sanctum')->group(function () {

    Route:: get('/teachers', [TeacherController::class, 'index']);
    Route::post('/teachers', [TeacherController::class,'store']);
    Route::get('/teachers/{id}', [TeacherController::class, 'show']);
    Route::put('/teachers/{id}', [TeacherController::class, 'update']);
    Route::delete('/teachers/{id}', [TeacherController::class, 'destroy']);
    Route::get('/list',[TeacherController::class,'list']);

    Route::get('/teachers-by-subject', [TeacherController::class, 'getBySubject']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/students', [StudentController::class, 'index']);
    Route::post('/students', [StudentController::class, 'store']);
    Route::get('/students/{id}', [StudentController::class, 'show']);
    Route::put('/students/{id}', [StudentController::class, 'update']);
    Route::delete('/students/{id}', [StudentController::class, 'destroy']);
    Route::get('/list-student', [StudentController::class,'list']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/school-classes', [SchoolClassController::class, 'index']);
    Route::post('/school-classes', [SchoolClassController::class, 'store']);
    Route::get('/school-classes/{id}', [SchoolClassController::class, 'show']);
    Route::put('/school-classes/{id}', [SchoolClassController::class, 'update']);
    Route::delete('/school-classes/{id}', [SchoolClassController::class, 'destroy']);
    Route::get('/list-classes', [SchoolClassController::class,'list']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/subjects', [SubjectController::class,'index']);
    Route::post('/subjects', [SubjectController::class, 'store']);
    Route::get('/subjects/{id}', [SubjectController::class, 'show']);
    Route::put('/subjects/{id}', [SubjectController::class, 'update']);
    Route::delete('/subjects/{id}', [SubjectController::class, 'destroy']);
    Route::get('/list-subjects', [SubjectController::class,'list']);

});
