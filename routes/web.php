<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/registration', [RegistrationController::class, 'create'])->name('registration.create');
Route::post('/registration', [RegistrationController::class, 'store'])->name('registration.store');

Route::get('/login', [LoginController::class, 'create'])->name('login.create');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

Route::post('/logout', [LogoutController::class, 'destroy'])->middleware('auth')->name('user.logout');

// todo: role admin
Route::middleware(['auth:sanctum', 'role:user'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/user/referral', [AdminController::class, 'referral'])->name('referral');
        Route::get('/user/log', [UserController::class, 'log'])->name('user.log');
        Route::get('/file', [UserController::class, 'file'])->name('file');
        Route::delete('/user/removeFile/{file}', [UserController::class, 'removeFile'])->name('user.removeFile');
        Route::resource('/user', UserController::class)->only(['index', 'edit', 'update', 'create', 'store']);
        Route::get('/settings/general', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings/general', [SettingController::class, 'general'])->name('settings.general');
        Route::resource('/content', ContentController::class);
        Route::resource('/notification', NotificationController::class);
    });
});
