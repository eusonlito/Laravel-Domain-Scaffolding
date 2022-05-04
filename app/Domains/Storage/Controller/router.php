<?php declare(strict_types=1);

namespace App\Domains\Storage\Controller;

use Illuminate\Support\Facades\Route;

Route::get('/storage/transform/{hash}/{time}/{transform}/{file}', Transform::class)->name('storage.transform')->where('file', '.*');
