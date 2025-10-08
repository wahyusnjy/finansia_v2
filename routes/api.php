<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/import-excel', [TransactionController::class, 'import_encrypted'])->name('import-locked-excel');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
