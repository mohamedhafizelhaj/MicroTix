<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('auth')->controller(AuthenticationController::class)->group(function() {

    Route::post('register', 'register');
    Route::post('login', 'login');

});

Route::prefix('event')->middleware('auth:sanctum')->controller(EventController::class)->group(function() {

    Route::middleware('organizer')->group(function() {
        Route::post('/', 'create');
        Route::patch('/', 'update');
        Route::delete('/{id}', 'delete');
        Route::get('/my', 'myEvents');
    });

    Route::get('/', 'getEvents');
    Route::get('/{id}', 'getEvent');

    Route::middleware('customer')->group(function () {
        Route::post('/pay', 'payForEvent');
        Route::get('/{id}/ticket', 'getTicket');
    });

});