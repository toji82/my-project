<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminContactController;
use App\Http\Controllers\ContactController;

// ログイン関連
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// 登録関連
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// ログアウト（任意）
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/admin',                [AdminContactController::class, 'index'])->name('admin.index');
    Route::get('/admin/search',         [AdminContactController::class, 'index'])->name('admin.search'); // 同じindexで検索
    Route::get('/admin/export',         [AdminContactController::class, 'export'])->name('admin.export');
    Route::get('/admin/contacts/{id}',  [AdminContactController::class, 'show'])->name('admin.contacts.show');
    Route::delete('/admin/contacts/{id}',[AdminContactController::class, 'destroy'])->name('admin.contacts.destroy');
    
Route::get('/contact', [ContactController::class,'create'])->name('contact.create');
Route::post('/contact/confirm', [ContactController::class,'confirm'])->name('contact.confirm');
Route::post('/contact/back',    [ContactController::class,'back'])->name('contact.back');
Route::post('/contact/store',   [ContactController::class,'store'])->name('contact.store');
Route::get('/contact/thanks',   [ContactController::class,'thanks'])->name('contact.thanks');
    
});
