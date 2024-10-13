<?php

use App\Http\Controllers\CombinedController;
use App\Http\Controllers\LayoutController;
use App\Http\Controllers\TalkController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LayoutController::class, 'init']);

Route::post('/generate', [CombinedController::class, 'generateSpeechAndSync']);
Route::get('/get-talks', [TalkController::class, 'getTalk']);
