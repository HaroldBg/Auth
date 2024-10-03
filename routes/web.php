<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

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
    return view('signup');
});
Route::group(['middleware' => 'guest'], function () {
    // register user
    Route::get('register', function () {
        return view('signup');
    })->name('register');
    // login user
    Route::get('login', function () {
        return view('login');
    })->name('login');
    //mail validation
    Route::get('account/{code}/activate', [AuthController::class, 'validateAccount'])->name('activate_account');
    //reset password mail
    Route::get('reset/{token}/password', [AuthController::class, 'resetView'])->name('reset.token.password');
    Route::get('reset_page', function () {
        return view('password_reset');
    })->name('reset-page');
    //reset password
    Route::get('password_reset', function () {
        return view('password_reset');
    })->name('pass_reset');
});


//dashbord route
Route::group(['middleware' => 'auth'], function () {
    Route::get('Dashboard', function () {
        return view('dashboard');
    })->name('Dashboard');
});
Route::get('logout', [AuthController::class, 'logout'])->name('logout');


// create user
Route::post('register', [AuthController::class, 'store'])->name('register.post');
Route::post('login', [AuthController::class, 'login']);
// reset password
Route::post('reset_pass', [AuthController::class, 'sendResetMail'])->name('reset.pass');
