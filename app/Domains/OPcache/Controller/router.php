<?php declare(strict_types=1);

namespace App\Domains\OPcache\Controller;

use Illuminate\Support\Facades\Route;

Route::get('/opcache/preload', Preload::class)->name('opcache.preload');
