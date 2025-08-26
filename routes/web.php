<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/users/{user}', [AdminController::class, 'userDetails'])->name('users.show');
        Route::put('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('users.update-role');
        
        Route::get('/tuition-posts', [AdminController::class, 'tuitionPosts'])->name('tuition-posts');
        Route::put('/tuition-posts/{post}/approve', [AdminController::class, 'approvePost'])->name('tuition-posts.approve');
        Route::put('/tuition-posts/{post}/reject', [AdminController::class, 'rejectPost'])->name('tuition-posts.reject');
        Route::delete('/tuition-posts/{post}', [AdminController::class, 'deletePost'])->name('tuition-posts.delete');
        
        Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
        Route::put('/reports/{report}/resolve', [AdminController::class, 'resolveReport'])->name('reports.resolve');
        Route::put('/reports/{report}/dismiss', [AdminController::class, 'dismissReport'])->name('reports.dismiss');
        
        Route::get('/subjects', [AdminController::class, 'subjects'])->name('subjects');
        Route::post('/subjects', [AdminController::class, 'storeSubject'])->name('subjects.store');
        Route::put('/subjects/{subject}', [AdminController::class, 'updateSubject'])->name('subjects.update');
        Route::delete('/subjects/{subject}', [AdminController::class, 'deleteSubject'])->name('subjects.delete');
        
        Route::get('/statistics', [AdminController::class, 'statistics'])->name('statistics');
    });

    // Student Routes
    Route::prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
        Route::get('/browse-tutors', [StudentController::class, 'browseTutors'])->name('browse-tutors');
        Route::get('/tutors/{tutor}', [StudentController::class, 'tutorProfile'])->name('tutor-profile');
        
        Route::get('/create-post', [StudentController::class, 'createPost'])->name('create-post');
        Route::post('/posts', [StudentController::class, 'storePost'])->name('posts.store');
        Route::get('/posts/{post}/edit', [StudentController::class, 'editPost'])->name('posts.edit');
        Route::put('/posts/{post}', [StudentController::class, 'updatePost'])->name('posts.update');
        Route::delete('/posts/{post}', [StudentController::class, 'deletePost'])->name('posts.delete');
        
        Route::get('/my-posts', [StudentController::class, 'myPosts'])->name('my-posts');
        Route::get('/posts/{post}', [StudentController::class, 'postDetails'])->name('post-details');
        
        Route::put('/applications/{application}/accept', [StudentController::class, 'acceptApplication'])->name('applications.accept');
        Route::put('/applications/{application}/reject', [StudentController::class, 'rejectApplication'])->name('applications.reject');
        
        Route::post('/report-user/{user}', [StudentController::class, 'reportUser'])->name('report-user');
        Route::post('/report-post/{post}', [StudentController::class, 'reportPost'])->name('report-post');
    });
});
