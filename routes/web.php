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
use App\Http\Controllers\ClassRecordItemController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\StudentController;

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
        Route::patch('/admin/submitted_requirements/{id}/approveEdit', [AdminSubmittedRequirementController::class, 'approveEdit'])->name('admin.submitted_requirements.approveEdit');

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

        Route::get('/admin/users', [App\Http\Controllers\UserController::class, 'index'])->name('admin.users.index');
        Route::get('/admin/users/create', [App\Http\Controllers\UserController::class, 'create'])->name('admin.users.create');
        Route::post('/admin/users', [App\Http\Controllers\UserController::class, 'store'])->name('admin.users.store');
        Route::get('/admin/users/{id}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/admin/users/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('admin.users.destroy');

        Route::get('/admin/sections', [App\Http\Controllers\SectionController::class, 'index'])->name('admin.sections.index');
        Route::get('/admin/sections/create', [App\Http\Controllers\SectionController::class, 'create'])->name('admin.sections.create');
        Route::post('/admin/sections', [App\Http\Controllers\SectionController::class, 'store'])->name('admin.sections.store');
        Route::get('/admin/sections/{id}/edit', [App\Http\Controllers\SectionController::class, 'edit'])->name('admin.sections.edit');
        Route::put('/admin/sections/{id}', [App\Http\Controllers\SectionController::class, 'update'])->name('admin.sections.update');
        Route::delete('/admin/sections/{id}', [App\Http\Controllers\SectionController::class, 'destroy'])->name('admin.sections.destroy');
        Route::get('/admin/sections/{id}/students', [App\Http\Controllers\SectionController::class, 'showStudents'])->name('admin.sections.showStudents');
        Route::delete('/admin/sections/{sectionId}/students/{studentId}', [App\Http\Controllers\SectionController::class, 'removeStudent'])->name('admin.sections.removeStudent');
        Route::post('/admin/sections/students/{studentId}', [App\Http\Controllers\SectionController::class, 'updateStudent'])->name('admin.sections.updateStudent');
        Route::post('/admin/sections/import-students', [App\Http\Controllers\SectionController::class, 'importStudents'])->name('admin.sections.importStudents');

        Route::post('/admin/notify/instructors', [App\Http\Controllers\AdminController::class, 'notifyInstructors'])->name('admin.notify.instructors');
        Route::post('/admin/notify/instructor', [App\Http\Controllers\AdminController::class, 'notifyInstructor'])->name('admin.notify.instructor');
    });

    Route::group(['middleware' => [InstructorMiddleware::class]], function () {
        Route::get('/instructor/dashboard', [InstructorController::class, 'dashboard'])->name('instructor.dashboard')->middleware(RedirectIfAuthenticated::class);
        Route::get('/instructor/classes', [App\Http\Controllers\SchoolClassController::class, 'instructorClasses'])->name('instructor.classes.index');
        Route::get('/instructor/classes/{id}/students', [App\Http\Controllers\SchoolClassController::class, 'showStudents'])->name('instructor.classes.students');
        Route::post('/instructor/classes/{id}/students/update-grades', [App\Http\Controllers\SchoolClassController::class, 'updateGrades'])->name('instructor.classes.students.update-grades');

        Route::get('/instructor/class-records', [ClassRecordController::class, 'index'])->name('instructor.class_records.index');
        Route::post('/instructor/class-records', [ClassRecordController::class, 'store'])->name('instructor.class_records.store');

        Route::get('/instructor/requirements', [SubmittedRequirementController::class, 'index'])->name('instructor.requirements.index');
        Route::get('/instructor/requirements/create', [SubmittedRequirementController::class, 'create'])->name('instructor.requirements.create');
        Route::post('/instructor/requirements', [SubmittedRequirementController::class, 'store'])->name('instructor.requirements.store');
        Route::get('/instructor/requirements/{id}/edit', [SubmittedRequirementController::class, 'edit'])->name('instructor.requirements.edit');
        Route::put('/instructor/requirements/{id}', [SubmittedRequirementController::class, 'update'])->name('instructor.requirements.update');
        Route::delete('/instructor/requirements/{id}', [SubmittedRequirementController::class, 'destroy'])->name('instructor.requirements.destroy');
        Route::get('/instructor/requirements/{id}/request-edit', [SubmittedRequirementController::class, 'requestEdit'])->name('instructor.requirements.requestEdit');

        Route::get('/instructor/class-record-items', [ClassRecordItemController::class, 'index'])->name('instructor.class-record-items.index');
        Route::post('/instructor/class-record-items', [ClassRecordItemController::class, 'store'])->name('instructor.class-record-items.store');
        Route::get('/instructor/grades', [GradeController::class, 'index'])->name('instructor.grades.index');

        Route::get('/instructor/class-records/{id}/pdf', [ClassRecordController::class, 'generatePDF'])->name('instructor.class_records.pdf');

        Route::get('/instructor/classes/{id}/add-student', [App\Http\Controllers\SchoolClassController::class, 'addStudent'])->name('instructor.classes.add-student');

        Route::post('/instructor/classes/{id}/add-students', [App\Http\Controllers\SchoolClassController::class, 'addStudentsStore'])->name('instructor.classes.students.store');

        Route::post('/instructor/classes/{id}/send-grades', [App\Http\Controllers\SchoolClassController::class, 'sendGrades'])->name('instructor.classes.students.send-grades');

        Route::post('/instructor/classes/{id}/share', [App\Http\Controllers\SchoolClassController::class, 'shareClass'])->name('instructor.classes.share');

        Route::get('/instructor/shared-records', [App\Http\Controllers\SharedClassRecordController::class, 'index'])->name('instructor.shared-records.index');
        Route::get('/instructor/shared-records/{id}', [App\Http\Controllers\SharedClassRecordController::class, 'show'])->name('instructor.shared-records.show');

        Route::get('/instructor/profile', [InstructorController::class, 'profile'])->name('instructor.profile');
        Route::put('/instructor/profile', [InstructorController::class, 'updateProfile'])->name('instructor.profile.update');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);
    Route::post('/notifications/send', [NotificationController::class, 'send']);
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/import-class-records', [ClassRecordController::class, 'import'])->name('class-records.import');

Route::post('/instructor/students/store', [StudentController::class, 'store'])->name('instructor.students.store');


