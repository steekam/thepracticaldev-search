<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
});

Route::get("/flush-redis", function() {
    abort_if(!App::environment('local'), 404);

    Redis::command('flushdb');
    return "Cleared";
});
