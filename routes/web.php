<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TuitionController;




Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view(view: 'dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('students', StudentController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('tuitions', TuitionController::class);
    Route::resource('courses', CourseController::class);

    Route::get('/courses/{id}', [CourseController::class, 'show'])->name('courses.show');
    Route::post('/courses/{id}/add-student', [CourseController::class, 'addStudent'])
        ->name('courses.addStudent');

    Route::post('/courses/{course}/enroll', [CourseController::class, 'enrollStudent'])
        ->name('courses.enroll');

    Route::put('/courses/{course}/students/{student}', [CourseController::class, 'updateEnrollment'])
        ->name('courses.updateEnrollment');

});


require __DIR__ . '/auth.php';
