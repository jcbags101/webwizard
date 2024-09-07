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
    Route::get('/instructors/{id}/edit', [InstructorController::class, 'edit'])->name('instructors.edit');
    Route::put('/instructors/{id}', [InstructorController::class, 'update'])->name('instructors.update');
    Route::delete('/instructors/{id}', [InstructorController::class, 'destroy'])->name('instructors.destroy');
});

Route::group(['middleware' => ['auth', 'student']], function () {
    Route::get('/student/dashboard', 'StudentController@dashboard')->name('student.dashboard');
});

Route::group(['middleware' => ['auth', 'instructor']], function () {
    Route::get('/instructor/dashboard', 'InstructorController@dashboard')->name('instructor.dashboard');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

