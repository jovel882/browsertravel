<?php

use App\Http\Controllers\HumidityController;
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

Route::get(
    '/',
    [HumidityController::class, 'showActualMap']
)
    ->name('map');
Route::prefix('history')->group(function () {
    Route::post(
        '/',
        [HumidityController::class, 'storeHistory']
    )
        ->name('history');
    Route::get(
        '/',
        [HumidityController::class, 'showHistory']
    )
        ->name('history.show');
    Route::get(
        '/{history}',
        [HumidityController::class, 'showHistoryDetail']
    )
        ->name('history.show.specific');
});

