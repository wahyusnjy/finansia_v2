<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use app\Http\Controllers\TransactionController;
use app\Http\Controllers\SavingController;
use app\Http\Controllers\CategoryTransactionController;
use app\Http\Controllers\BankController;
use app\Http\Controllers\BusinessController;
use app\Http\Controllers\NotesController;
use app\Http\Controllers\ReportWeeklyController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

     Route::prefix('/transaksi')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('transaksi');
        Route::get('/create', [TransactionController::class, 'create'])->name('transaksi.create');
        Route::post('/store', [TransactionController::class, 'store'])->name('transaksi.store');
        Route::get('/edit/{id}', [TransactionController::class,'edit'])->name('transaksi.edit');
        Route::post('/update/{id}', [TransactionController::class, 'update'])->name('transaksi.update');
        Route::post('/import', [TransactionController::class, 'import'])->name('transaksi.import');
        Route::delete('/delete/{id}', [TransactionController::class, 'destroy'])->name('transaksi.delete');
    });
    Route::prefix('/savings')->group(function () {
        Route::get('/', [SavingController::class, 'index'])->name('savings');
        Route::get('/create', [SavingController::class, 'create'])->name('savings.create');
        Route::post('/store', [SavingController::class, 'store'])->name('savings.store');
        Route::get('/edit/{id}', [SavingController::class, 'edit'])->name('savings.edit');
        Route::post('/update/{id}', [SavingController::class, 'update'])->name('savings.update');
        Route::delete('/delete/{id}',[SavingController::class, 'destroy'])->name('savings.delete');
    });
    Route::prefix('/categories')->group(function () {
        Route::get('/', [CategoryTransactionController::class, 'index'])->name('categories');
        Route::get('/create', [CategoryTransactionController::class, 'create'])->name('categories.create');
        Route::post('/store', [CategoryTransactionController::class, 'store'])->name('categories.store');
        Route::get('/edit/{id}', [CategoryTransactionController::class, 'edit'])->name('categories.edit');
        Route::post('/update/{id}', [CategoryTransactionController::class, 'update'])->name('categories.update');
        Route::delete('/delete/{id}',[CategoryTransactionController::class, 'destroy'])->name('categories.delete');
    });
    Route::prefix('/bank')->group(function () {
        Route::get('/', [BankController::class , 'index'])->name('bank');
        Route::get('/create', [BankController::class , 'create'])->name('bank.create');
        Route::post('/store', [BankController::class , 'store'])->name('bank.store');
        Route::get('/edit/{id}', [BankController::class , 'edit'])->name('bank.edit');
        Route::post('/update/{id}', [BankController::class , 'update'])->name('bank.update');
        Route::post('/delete', [BankController::class , 'destroy'])->name('bank.destroy');
    });
    Route::prefix('/business')->group(function () {
        Route::get('/', [BusinessController::class , 'index'])->name('business');
        Route::get('/create', [BusinessController::class , 'create'])->name('business.create');
        Route::post('/store', [BusinessController::class , 'store'])->name('business.store');
        Route::get('/edit/{id}', [BusinessController::class , 'edit'])->name('business.edit');
        Route::post('/update/{id}', [BusinessController::class , 'update'])->name('business.update');
        Route::post('/delete', [BusinessController::class , 'destroy'])->name('business.destroy');
        Route::get('/delete', [BusinessController::class , 'destroy'])->name('business.destroy');
    });
    Route::prefix('/notes')->group(function () {
        Route::get('/', [NotesController::class , 'index'])->name('notes');
        Route::get('/create', [NotesController::class , 'create'])->name('notes.create');
        Route::post('/store', [NotesController::class , 'store'])->name('notes.store');
        Route::get('/edit/{id}', [NotesController::class , 'edit'])->name('notes.edit');
        Route::post('/update/{id}', [NotesController::class , 'update'])->name('notes.update');
        Route::post('/delete', [NotesController::class , 'destroy'])->name('notes.destroy');
    });

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
