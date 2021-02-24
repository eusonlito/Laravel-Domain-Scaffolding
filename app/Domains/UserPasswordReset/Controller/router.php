<?php declare(strict_types=1);

namespace App\Domains\UserPasswordReset\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'user.auth.redirect'], static function () {
    Route::any('/user/password/reset', Start::class)->name('user-password-reset.start');
    Route::any('/user/password/reset/{hash}', Finish::class)->name('user-password-reset.finish');
});
