<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::middleware(['guest'])->group(function (){
    Route::post('/login', 'Auth\AuthController@login')->name('login');
    Route::post('/register', 'Auth\RegisterController@register');
    Route::post('/forgot-password', 'Auth\ForgotPasswordController@forgot');
    Route::post('/reset-password', 'Auth\ForgotPasswordController@reset')->name('password.reset');
});

Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');

Route::middleware(['auth:sanctum'])->group(function () {
    // Logout
    Route::post('/logout', 'Auth\AuthController@logout');

    // Email Verification
    Route::get('/email/verify', 'Auth\VerificationController@index')->name('verification.notice');
    Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

    Route::middleware(['verified'])->group(function (){
        // Profile
        Route::get('/profile', 'UserController@me');
        Route::post('/update/password', 'UserController@changePassword');
        Route::post('/update/profile', 'UserController@changeProfile');
    });
});
