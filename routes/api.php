<?php

use Illuminate\Support\Facades\Route;

Route::prefix('calculator')->group(function () {
    Route::post('calculate', [\App\Http\Controllers\CalculatorController::class, 'calculate']);

    Route::get('history', [\App\Http\Controllers\CalculatorController::class, 'history']);
    Route::delete('history/{calculation}', [\App\Http\Controllers\CalculatorController::class, 'delete']);
    Route::delete('history', [\App\Http\Controllers\CalculatorController::class, 'deleteAll']);
});
