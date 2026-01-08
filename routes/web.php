<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\RuangController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\KomunitasController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\ReportController;

// Default route - redirect to login
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('home');
    }
    return redirect()->route('login');
});

// Auth routes (guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

// Logout route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes (require authentication)
Route::middleware('auth')->group(function () {
    // Onboarding / Interest Selection
    Route::get('/minat', [OnboardingController::class, 'show'])->name('minat');
    Route::post('/minat', [OnboardingController::class, 'save'])->name('minat.save');

    // Home/Beranda
    Route::get('/beranda', [HomeController::class, 'index'])->name('home');

    // Questions page
    Route::get('/pertanyaan', [PertanyaanController::class, 'index'])->name('pertanyaan');
    Route::post('/pertanyaan', [PertanyaanController::class, 'store'])->name('pertanyaan.store');
    Route::post('/pertanyaan/{question}/jawab', [PertanyaanController::class, 'answer'])->name('pertanyaan.answer');
    Route::get('/pertanyaan/{question}/jawaban', [PertanyaanController::class, 'getAnswers'])->name('pertanyaan.answers');

    // Notifications page
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi');
    Route::post('/notifikasi/{notification}/read', [NotifikasiController::class, 'markAsRead'])->name('notifikasi.read');
    Route::post('/notifikasi/read-all', [NotifikasiController::class, 'markAllAsRead'])->name('notifikasi.readAll');

    // Community/Komunitas page
    Route::get('/komunitas', [KomunitasController::class, 'index'])->name('komunitas');

    // Ruang/Category pages
    Route::get('/ruang/{slug}', [RuangController::class, 'show'])->name('ruang.show');
    Route::post('/ruang', [RuangController::class, 'store'])->name('ruang.store');

    // Profile pages
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
    Route::get('/profil/{username}', [ProfilController::class, 'show'])->name('profil.show');

    // Follow routes
    Route::post('/user/{user}/follow', [FollowController::class, 'toggle'])->name('user.follow');
    Route::post('/room/{category}/follow', [RuangController::class, 'toggleFollow'])->name('room.follow');


    // Post routes
    Route::post('/post', [PostController::class, 'store'])->name('post.store');
    Route::get('/post/{post}', [PostController::class, 'show'])->name('post.show');
    Route::delete('/post/{post}', [PostController::class, 'destroy'])->name('post.destroy');
    Route::post('/post/{post}/like', [PostController::class, 'toggleLike'])->name('post.like');
    Route::post('/post/{post}/comment', [PostController::class, 'comment'])->name('post.comment');
    Route::get('/post/{post}/comments', [PostController::class, 'getComments'])->name('post.comments');
    Route::post('/post/{post}/reshare', [PostController::class, 'toggleReshare'])->name('post.reshare');
    Route::post('/post/{post}/save', [PostController::class, 'toggleSave'])->name('post.save');
    Route::get('/post/{post}/link', [PostController::class, 'getLink'])->name('post.link');
    Route::post('/post/{post}/report', [ReportController::class, 'store'])->name('post.report');

    // Comment reply
    Route::post('/comment/{comment}/reply', [PostController::class, 'replyComment'])->name('comment.reply');

    // Draft posts
    Route::get('/drafts', [PostController::class, 'drafts'])->name('drafts');
    Route::post('/draft/{post}/publish', [PostController::class, 'publishDraft'])->name('draft.publish');

    // Search
    Route::get('/search', [SearchController::class, 'search'])->name('search');
    Route::get('/search/posts', [SearchController::class, 'searchPosts'])->name('search.posts');
    Route::get('/search/users', [SearchController::class, 'searchUsers'])->name('search.users');

    // Settings
    Route::get('/pengaturan', [SettingsController::class, 'index'])->name('settings');
    Route::put('/pengaturan/email', [SettingsController::class, 'updateEmail'])->name('settings.email');
    Route::put('/pengaturan/bahasa', [SettingsController::class, 'updateLanguage'])->name('settings.language');
    Route::put('/pengaturan/privasi', [SettingsController::class, 'updatePrivacy'])->name('settings.privacy');
    Route::put('/pengaturan/password', [SettingsController::class, 'updatePassword'])->name('settings.password');

    // Help/Bantuan
    Route::get('/bantuan', [HelpController::class, 'index'])->name('help');
    Route::post('/bantuan', [HelpController::class, 'store'])->name('help.store');
});

