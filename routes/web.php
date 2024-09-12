<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\InstructorController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', 'AuthController@login')->name('login');


Route::group(['middleware' => ['auth']], function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/admin/instructors/create', [InstructorController::class, 'create'])->name('admin.instructors.create');
    Route::post('/admin/instructors', [InstructorController::class, 'store'])->name('admin.instructors.store');
    Route::get('/instructors', [InstructorController::class, 'index'])->name('admin.instructors.index');
    Route::put('/instructors/{id}', [InstructorController::class, 'update'])->name('instructors.update');
    Route::delete('/instructors/{id}', [InstructorController::class, 'destroy'])->name('instructors.destroy');
    Route::get('/instructors/{id}/edit', [InstructorController::class, 'edit'])->name('instructors.edit');

    Route::get('/admin/subjects', [App\Http\Controllers\SubjectController::class, 'index'])->name('admin.subjects.index');
    Route::get('/admin/subjects/create', [App\Http\Controllers\SubjectController::class, 'create'])->name('admin.subjects.create');
    Route::post('/admin/subjects', [App\Http\Controllers\SubjectController::class, 'store'])->name('admin.subjects.store');
    Route::get('/admin/subjects/{id}/edit', [App\Http\Controllers\SubjectController::class, 'edit'])->name('admin.subjects.edit');
    Route::put('/admin/subjects/{id}', [App\Http\Controllers\SubjectController::class, 'update'])->name('admin.subjects.update');
    Route::delete('/admin/subjects/{id}', [App\Http\Controllers\SubjectController::class, 'destroy'])->name('admin.subjects.destroy');

    Route::get('/admin/requirements', [App\Http\Controllers\RequirementController::class, 'index'])->name('admin.requirements.index');
    Route::get('/admin/requirements/create', [App\Http\Controllers\RequirementController::class, 'create'])->name('admin.requirements.create');
    Route::post('/admin/requirements', [App\Http\Controllers\RequirementController::class, 'store'])->name('admin.requirements.store');
    Route::get('/admin/requirements/{id}', [App\Http\Controllers\RequirementController::class, 'show'])->name('admin.requirements.show');
    Route::get('/admin/requirements/{id}/edit', [App\Http\Controllers\RequirementController::class, 'edit'])->name('admin.requirements.edit');
    Route::put('/admin/requirements/{id}', [App\Http\Controllers\RequirementController::class, 'update'])->name('admin.requirements.update');
    Route::delete('/admin/requirements/{id}', [App\Http\Controllers\RequirementController::class, 'destroy'])->name('admin.requirements.destroy');

    Route::get('/admin/classes', [App\Http\Controllers\SchoolClassController::class, 'index'])->name('admin.classes.index');
    Route::get('/admin/classes/create', [App\Http\Controllers\SchoolClassController::class, 'create'])->name('admin.classes.create');
    Route::post('/admin/classes', [App\Http\Controllers\SchoolClassController::class, 'store'])->name('admin.classes.store');
    Route::get('/admin/classes/{id}/edit', [App\Http\Controllers\SchoolClassController::class, 'edit'])->name('admin.classes.edit');
    Route::put('/admin/classes/{id}', [App\Http\Controllers\SchoolClassController::class, 'update'])->name('admin.classes.update');
    Route::delete('/admin/classes/{id}', [App\Http\Controllers\SchoolClassController::class, 'destroy'])->name('admin.classes.destroy');
    

    
});

Route::group(['middleware' => ['auth', 'student']], function () {
    Route::get('/student/dashboard', 'StudentController@dashboard')->name('student.dashboard');
});

Route::group(['middleware' => ['auth', 'instructor']], function () {
    Route::get('/instructor/dashboard', 'InstructorController@dashboard')->name('instructor.dashboard');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

