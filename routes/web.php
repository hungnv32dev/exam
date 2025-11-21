<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\TestController;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Test Routes (for debugging)
Route::get('/test/users', [TestController::class, 'testLogin']);
Route::get('/test/auth', [TestController::class, 'testAuth']);

// Password Reset Routes (placeholder)
Route::get('/forgot-password', function () {
    return redirect()->route('login');
})->name('password.request');

Route::get('/register', function () {
    return redirect()->route('login');
})->name('register');

// Google OAuth routes
Route::get('/auth/google', [App\Http\Controllers\Auth\SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\SocialAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// Protected Routes - Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // User management routes
    Route::get('/users', [AdminDashboardController::class, 'users'])->name('admin.users');
    Route::get('/users/create', [AdminDashboardController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [AdminDashboardController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{user}', [AdminDashboardController::class, 'show'])->name('admin.users.show');
    Route::get('/users/{user}/edit', [AdminDashboardController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [AdminDashboardController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminDashboardController::class, 'destroy'])->name('admin.users.destroy');

    // Question management routes
    Route::get('/questions', [QuestionController::class, 'index'])->name('admin.questions.index');
    Route::get('/questions/create', [QuestionController::class, 'create'])->name('admin.questions.create');
    Route::post('/questions', [QuestionController::class, 'store'])->name('admin.questions.store');
    Route::get('/questions/{question}', [QuestionController::class, 'show'])->name('admin.questions.show');
    Route::get('/questions/{question}/edit', [QuestionController::class, 'edit'])->name('admin.questions.edit');
    Route::put('/questions/{question}', [QuestionController::class, 'update'])->name('admin.questions.update');
    Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('admin.questions.destroy');

    // Exam management routes
    Route::get('/exams', [ExamController::class, 'index'])->name('admin.exams.index');
    Route::get('/exams/create', [ExamController::class, 'create'])->name('admin.exams.create');
    Route::post('/exams', [ExamController::class, 'store'])->name('admin.exams.store');
    Route::get('/exams/{exam}', [ExamController::class, 'show'])->name('admin.exams.show');
    Route::get('/exams/{exam}/edit', [ExamController::class, 'edit'])->name('admin.exams.edit');
    Route::put('/exams/{exam}', [ExamController::class, 'update'])->name('admin.exams.update');
    Route::delete('/exams/{exam}', [ExamController::class, 'destroy'])->name('admin.exams.destroy');
    Route::get('/exams/{exam}/clone', [ExamController::class, 'clone'])->name('admin.exams.clone');
    Route::post('/exams/{exam}/clone', [ExamController::class, 'storeClone'])->name('admin.exams.clone.store');

    // Import Users routes
    Route::get('/import/users', [\App\Http\Controllers\Admin\ImportController::class, 'showImportForm'])->name('admin.import.users');
    Route::post('/import/users', [\App\Http\Controllers\Admin\ImportController::class, 'importUsers'])->name('admin.import.users.store');
    Route::get('/import/users/template', [\App\Http\Controllers\Admin\ImportController::class, 'downloadTemplate'])->name('admin.import.users.template');

    // API routes for AJAX
    Route::get('/api/questions', [ExamController::class, 'getQuestions'])->name('admin.api.questions');
    Route::get('/api/students', [ExamController::class, 'getStudents'])->name('admin.api.students');
});

// Protected Routes - Student
Route::middleware(['auth', 'role:student'])->prefix('student')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
    Route::get('/profile', [StudentDashboardController::class, 'profile'])->name('student.profile');

    // Exam routes for students
    Route::get('/exams', [StudentDashboardController::class, 'exams'])->name('student.exams');
    Route::get('/exams/{exam}/start', [StudentDashboardController::class, 'startExam'])->name('student.exam.start');
    Route::post('/exams/{exam}/submit', [StudentDashboardController::class, 'submitExam'])->name('student.exam.submit');
    Route::post('/exams/{exam}/autosave', [StudentDashboardController::class, 'autoSave'])->name('student.exam.autosave');
    Route::get('/exams/{exam}/result', [StudentDashboardController::class, 'examResult'])->name('student.exam.result');
});

// Legacy dashboard route (redirect based on role)
Route::middleware('auth')->get('/dashboard', function () {
    $user = auth()->user();
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isStudent()) {
        return redirect()->route('student.dashboard');
    }
    return redirect()->route('login');
})->name('dashboard');
