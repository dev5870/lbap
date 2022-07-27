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
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\Cabinet\CabinetController;
use App\Http\Controllers\Cabinet\SecurityController;
use App\Http\Controllers\Cabinet\UserController as CabinetUserController;
use App\Http\Controllers\Cabinet\ContentController as CabinetContentController;
use App\Http\Controllers\Cabinet\ProfileController;
use App\Http\Controllers\Cabinet\PaymentController as CabinetPaymentController;

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
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/user/referral', [AdminController::class, 'referral'])->name('referral');
        Route::get('/notice', [AdminController::class, 'systemNotice'])->name('notice');
        Route::get('/transaction', [AdminController::class, 'transaction'])->name('transaction');
        Route::get('/user/log', [UserController::class, 'log'])->name('user.log');
        Route::get('/file', [UserController::class, 'file'])->name('file');
        Route::delete('/user/removeFile/{file}', [UserController::class, 'removeFile'])->name('user.removeFile');
        Route::resource('/user', UserController::class)->only(['index', 'edit', 'update', 'create', 'store']);
        Route::get('/settings/general', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings/general', [SettingController::class, 'general'])->name('settings.general');
        Route::resource('/content', ContentController::class);
        Route::resource('/notification', NotificationController::class);
        Route::resource('/payment', PaymentController::class);
        Route::resource('/address', AddressController::class);

        Route::prefix('statistic')->name('statistic.')->group(function () {
            Route::get('/user', [StatisticController::class, 'user'])->name('user');
            Route::get('/finance', [StatisticController::class, 'finance'])->name('finance');
        });
    });
});

// todo: role user
Route::middleware(['auth:sanctum', 'role:user', 'activity'])->group(function () {
    Route::prefix('cabinet')->name('cabinet.')->group(function () {

        Route::get('/', [CabinetController::class, 'index'])->name('index');

        Route::prefix('user')->group(function () {
            Route::resource('/profile', ProfileController::class);
            Route::get('/edit', [CabinetUserController::class, 'edit'])->name('user.edit');
            Route::get('/security', [SecurityController::class, 'index'])->name('user.security');
            Route::post('/security', [SecurityController::class, 'update'])->name('user.security.update');
            Route::get('/log', [CabinetUserController::class, 'log'])->name('user.log');
            Route::get('/referral', [CabinetUserController::class, 'referral'])->name('user.referral');
        });

        Route::prefix('content')->group(function () {
            Route::get('/', [CabinetContentController::class, 'index'])->name('content.index');
            Route::get('/{content}', [CabinetContentController::class, 'show'])->name('content.show');
        });

        Route::get('/payment/withdraw', [CabinetPaymentController::class, 'withdraw'])->name('payment.withdraw');
        Route::resource('/payment', CabinetPaymentController::class);
    });
});
