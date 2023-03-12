<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/clock-in', [WorkerController::class, 'clock_in']);

Route::get('/clock-ins', [WorkerController::class, 'get_clock_ins']);