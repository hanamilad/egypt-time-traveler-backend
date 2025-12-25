<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin');

Route::fallback(function () {
    abort(404);
});
