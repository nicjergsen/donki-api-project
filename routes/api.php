<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\InstrumentController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\InstrumentActivityUsageController;

Route::get('/instruments', [InstrumentController::class, 'index']);
Route::get('instruments/usage', [InstrumentController::class, 'usage']);
Route::get('/activities', [ActivityController::class, 'index']);
Route::get('/instrument-activity', [InstrumentActivityUsageController::class, 'index']);

