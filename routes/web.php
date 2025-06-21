<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-register', function () {
    return view('test-register');
});

Route::get('/health', function() {
    return response()->json([
        'status' => 'up',
        'port' => $_SERVER['SERVER_PORT'] ?? 'unknown',
        'bind' => $_SERVER['SERVER_ADDR'] ?? 'unknown',
        'hostname' => gethostname() ?: 'unknown'
    ]);
});
