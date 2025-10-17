<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaptopController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\ServiceitemController;


Route::get('/user-edit', function () {
    return view('pages.user.edit');
});
Route::get('/serviceitem-edit', function () {
    return view('pages.serviceitem.edit');
});
Route::get('/laptop-edit', function () {
    return view('pages.laptop.edit');
});
Route::get('/services-detail', function () {
    return view('pages.services.show');
});


Route::resource('/', HomeController::class)->only(['index']);
Route::resource('/user', UserController::class);
Route::resource('/laptop', LaptopController::class);
Route::resource('/serviceitem', ServiceitemController::class);


Route::resource('/services', ServicesController::class);