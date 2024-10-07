<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\InstructorController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\InstructorMiddleware;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\SubmittedRequirementController;
use App\Http\Controllers\AdminSubmittedRequirementController;
use App\Http\Controllers\ClassRecordController;
use App\Http\Controllers\GradeController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', 'AuthController@login')->name('login');


Route::middleware(['auth'])->group(function () {
    Route::group(['middleware' => [AdminMiddleware::class]], function () {
        Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware(RedirectIfAuthenticated::class);

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

        Route::get('/admin/submitted_requirements', [AdminSubmittedRequirementController::class, 'index'])->name('admin.submitted_requirements.index');
        Route::put('/admin/submitted_requirements/{id}', [AdminSubmittedRequirementController::class, 'update'])->name('admin.submitted_requirements.update');
        Route::delete('/admin/submitted_requirements/{id}', [AdminSubmittedRequirementController::class, 'destroy'])->name('admin.submitted_requirements.destroy');
        Route::get('/admin/submitted_requirements/{id}/edit', [AdminSubmittedRequirementController::class, 'edit'])->name('admin.submitted_requirements.edit');

        Route::get('/admin/classes', [App\Http\Controllers\SchoolClassController::class, 'index'])->name('admin.classes.index');
        Route::get('/admin/classes/create', [App\Http\Controllers\SchoolClassController::class, 'create'])->name('admin.classes.create');
        Route::post('/admin/classes', [App\Http\Controllers\SchoolClassController::class, 'store'])->name('admin.classes.store');
        Route::get('/admin/classes/{id}/edit', [App\Http\Controllers\SchoolClassController::class, 'edit'])->name('admin.classes.edit');
        Route::put('/admin/classes/{id}', [App\Http\Controllers\SchoolClassController::class, 'update'])->name('admin.classes.update');
        Route::delete('/admin/classes/{id}', [App\Http\Controllers\SchoolClassController::class, 'destroy'])->name('admin.classes.destroy');

        Route::get('/admin/rates', [App\Http\Controllers\RateController::class, 'index'])->name('admin.rates.index');
        Route::get('/admin/rates/create', [App\Http\Controllers\RateController::class, 'create'])->name('admin.rates.create');
        Route::post('/admin/rates', [App\Http\Controllers\RateController::class, 'store'])->name('admin.rates.store');
        Route::get('/admin/rates/{id}', [App\Http\Controllers\RateController::class, 'show'])->name('admin.rates.show');
        Route::get('/admin/rates/{id}/edit', [App\Http\Controllers\RateController::class, 'edit'])->name('admin.rates.edit');
        Route::put('/admin/rates/{id}', [App\Http\Controllers\RateController::class, 'update'])->name('admin.rates.update');
        Route::delete('/admin/rates/{id}', [App\Http\Controllers\RateController::class, 'destroy'])->name('admin.rates.destroy');
    });

    Route::group(['middleware' => [InstructorMiddleware::class]], function () {
        Route::get('/instructor/dashboard', [InstructorController::class, 'dashboard'])->name('instructor.dashboard')->middleware(RedirectIfAuthenticated::class);
        Route::get('/instructor/classes', [App\Http\Controllers\SchoolClassController::class, 'instructorClasses'])->name('instructor.classes.index');

        Route::get('/instructor/class-records', [ClassRecordController::class, 'index'])->name('instructor.class_records.index');

        Route::get('/instructor/requirements', [SubmittedRequirementController::class, 'index'])->name('instructor.requirements.index');
        Route::get('/instructor/requirements/create', [SubmittedRequirementController::class, 'create'])->name('instructor.requirements.create');
        Route::post('/instructor/requirements', [SubmittedRequirementController::class, 'store'])->name('instructor.requirements.store');
        Route::get('/instructor/requirements/{id}/edit', [SubmittedRequirementController::class, 'edit'])->name('instructor.requirements.edit');
        Route::put('/instructor/requirements/{id}', [SubmittedRequirementController::class, 'update'])->name('instructor.requirements.update');
        Route::delete('/instructor/requirements/{id}', [SubmittedRequirementController::class, 'destroy'])->name('instructor.requirements.destroy');

        Route::get('/instructor/grades', [GradeController::class, 'index'])->name('instructor.grades.index');
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/import-class-records', [ClassRecordController::class, 'import'])->name('class-records.import');


