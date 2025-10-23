<?php

use App\Http\Middleware\EnsureActive;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LaptopController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\ServiceitemController;






// Route::get('/user-edit', function () {
//     return view('pages.user.edit');
// });
// Route::get('/serviceitem-edit', function () {
//     return view('pages.serviceitem.edit');
// });
// Route::get('/login', function () {
//     return view('login');
// });
// Route::get('/services-detail', function () {
//     return view('pages.services.show');
// });


Route::view('/403', 'errors.403')->name('error403');
Route::view('/404', 'errors.404')->name('error404');


// Login & Logout
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Semua route yang butuh login + user aktif
Route::middleware(['auth', EnsureActive::class])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::resource('/user', UserController::class);
    Route::post('/user/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('user.toggle-status');
    Route::resource('/laptop', LaptopController::class);
Route::post('/laptop/toggle-status/{id}', [LaptopController::class, 'toggleStatus'])->name('laptop.toggle-status');
    Route::resource('/serviceitem', ServiceitemController::class);
    Route::post('/serviceitem/{id}/toggle-status', [ServiceitemController::class, 'toggleStatus'])->name('serviceitem.toggle-status');
    Route::resource('/services', ServicesController::class);
});
