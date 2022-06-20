<?php declare(strict_types=1);

namespace App\Domains\User\Controller;

use Illuminate\Support\Facades\Route;

Route::get('/user/confirm/{hash}', ConfirmFinish::class)->name('user.confirm.finish');

Route::group(['middleware' => 'user.auth.redirect'], static function () {
    Route::any('/user/auth', AuthCredentials::class)->name('user.auth.credentials');
    Route::any('/user/signup', Signup::class)->name('user.signup');
});

Route::group(['middleware' => ['user.auth', 'user.enabled']], static function () {
    Route::any('/user/confirm', ConfirmStart::class)->name('user.confirm.start');
});

Route::group(['middleware' => ['user-auth']], static function () {
    Route::any('/user/profile', UpdateProfile::class)->name('user.update.profile');
    Route::any('/user/api', UpdateApi::class)->name('user.update.api');
    Route::any('/user/disabled', Disabled::class)->name('user.disabled');
    Route::get('/user/logout', Logout::class)->name('user.logout');
});
