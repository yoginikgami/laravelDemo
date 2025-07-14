<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\TeacherDashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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


require __DIR__ . '/auth.php';

// Route::resource('/user', UserController::class);
// Route::resource('teacher', TeacherController::class);
// Route::resource('student', StudentController::class);
// Route::resource('schoolClass', SchoolClassController::class);
// Route::resource('subject', SubjectController::class);
// Route::resource('roles', RoleController::class);

Route::middleware(['auth', 'permission:view dashboard'])->group(function () {
    Route::get('/admin/dashboard/admin', [AdminDashboardController::class, 'index'])
        ->name('admin.admindashboard');
});

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin/dashboard/admin', [AdminDashboardController::class, 'index'])->name('admin.admindashboard');
});

Route::middleware(['auth', 'role:Teacher'])->group(function () {
    Route::get('/admin/dashboard/teacher', [TeacherDashboardController::class, 'index'])
        ->name('admin.teacherdashboard');
});

Route::middleware(['auth', 'role:Student'])->group(function () {
    Route::get('/admin/dashboard/student', [StudentDashboardController::class, 'index'])
        ->name('admin.studentDashboard');
});


Route::middleware(['auth', 'permission:manage students'])->group(function () {
    Route::resource('student', StudentController::class);

    Route::controller(StudentController::class)->prefix('students')->name('student.')->group(function () {
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
    });
});

Route::middleware(['auth', 'permission:manage teachers'])->group(function () {
    Route::resource('teacher', TeacherController::class);

    Route::controller(TeacherController::class)->prefix('teachers')->name('teacher.')->group(function () {
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
    });
});

Route::middleware(['auth', 'permission:manage school classes'])->group(function () {
    Route::resource('schoolclass', SchoolClassController::class); 
    Route::controller(SchoolClassController::class)->prefix('schoolclasses')->name('schoolclass.')->group(function () {
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
    });
});


// Route::middleware(['auth', 'permission:manage school classes'])->group(function () {
//     Route::resource('schoolclass', SchoolClassController::class);

//     Route::controller(SchoolClassController::class)->prefix('schoolclasses')->name('schoolclass.')->group(function () {
//         Route::get('/create', 'create')->name('create');
//         Route::post('/store', 'store')->name('store');
//         Route::get('/{id}/edit', 'edit')->name('edit');
//         Route::put('/{id}', 'update')->name('update');
//     });
// });

Route::middleware(['auth', 'permission:manage subjects'])->group(function () {
    Route::resource('subject', SubjectController::class);

    Route::controller(SubjectController::class)->prefix('subjects')->name('subject.')->group(function () {
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
    });
});


Route::get('/get-roll-no', [StudentController::class, 'getLastRollNumber']);

Route::get('/teachers-by-subject', [TeacherController::class, 'getBySubject'])->name('teachers.by.subject');


Route::put('/student/photo/{id}', [StudentDashboardController::class, 'updatePhoto'])->name('student.updatePhoto');
Route::put('/teacher/photo/{id}', [TeacherDashboardController::class, 'updatePhoto'])->name('teacher.updatePhoto');

Route::put('/student/dashboard/update/{id}', [StudentDashboardController::class, 'update'])->name('student.dashboard.update');
Route::put('/teacher/dashboard/update/{id}', [TeacherDashboardController::class, 'update'])->name('teacher.dashboard.update');
