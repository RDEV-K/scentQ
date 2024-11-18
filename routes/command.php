<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

use function PHPUnit\Framework\returnSelf;

Route::get('/optimize-clear', function () {
    Artisan::call('optimize:clear');
    return redirect()->back();
})->name('cache.clear');
