<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\TeacherDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\StudentDashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Login
Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');


require __DIR__.'/auth.php';

Route::resource('/user', UserController::class);
Route::resource('teacher', TeacherController::class);
Route::resource('student', StudentController::class);
Route::resource('schoolClass', SchoolClassController::class);
Route::resource('subject', SubjectController::class);


Route::controller(TeacherController::class)->prefix('teachers')->name('teacher.')->group(function () {

    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store') ;
    Route::get('/{id}/edit', 'edit')->name('edit') ;
    Route::put('/{id}', 'update')->name('update') ;

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

Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('admin.dashboard');

Route::get('/admin/dashboard/student', [StudentDashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('admin.studentDashboard');

Route::put('/student/photo/{id}', [StudentDashboardController::class, 'updatePhoto'])->name('student.updatePhoto');

Route::put('/student/dashboard/update/{id}', [StudentDashboardController::class, 'update'])->name('dashboardupdate');

// Route::get('/student/profile', [StudentDashboardController::class, 'profile'])->name('student.profile');
Route::put('/teacher/photo/{id}', [StudentDashboardController::class, 'updatePhoto'])->name('teacher.updatePhoto');
