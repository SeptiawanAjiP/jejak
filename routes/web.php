<?php

use Illuminate\Support\Facades\Route;
use Dewakoding\Jejak\Http\Livewire\JejakDashboard;

Route::group([
    'prefix' => config('jejak.route.prefix', 'jejak'),
    'middleware' => config('jejak.route.middleware', ['web', 'auth']),
    'as' => config('jejak.route.name', 'jejak.'),
], function () {
    Route::get('/', JejakDashboard::class)->name('index');
    Route::get('/analytics', JejakDashboard::class)->name('analytics');
});