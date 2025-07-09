<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SchoolClassController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('login', function () {
    return view('./auth/login');
});

Route::get('register', function () {
    return view('./auth/register');
});


Route::get('dashoard', function () {
    return view('./admin/dashboard');
});

Route::resource('/user', UserController::class);
Route::resource('teacher', TeacherController::class);
Route::resource('student', StudentController::class);
Route::resource('schoolClass', SchoolClassController::class);
Route::resource('subject', SubjectController::class);

Route::controller(TeacherController::class)->prefix('teachers')->name('teacher.')->group(function () {

    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::put('/{id}', 'update')->name('update');

});


Route::controller(StudentController::class)->prefix('students')->name('student.')->group(function () {

    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::put('/{id}', 'update')->name('update');

});

Route::get('/get-roll-no', [StudentController::class, 'getLastRollNumber']);

Route::controller(SchoolClassController::class)->prefix('schoolClasses')->name('schoolClass')->group(function(){
    Route::post('/store','store')->name('store');
    Route::get('/create','create')->name('create');
    Route::get('/{id}/edit','edit')->name('edit');
    Route::put('/{id}', 'update')->name('update');
});

Route::get('/teachers-by-subject', [TeacherController::class, 'getBySubject'])->name('teachers.by.subject');


Route::controller(SubjectController::class)->prefix('subjects')->name('subject.')->group(function () {

    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::put('/{id}', 'update')->name('update');

});
