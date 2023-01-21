<?php

use App\Http\Controllers\CodeCardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\Transactions\TransactionsController;
use App\Http\Controllers\Transactions\TransferMoneyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'auth2'])->group(function () {
    Route::get('/accounts', [AccountsController::class, 'index'])->name('accounts');
    Route::get('/accounts/create', [AccountsController::class, 'create'])->name('account.showCreateForm');
    Route::post('/accounts/create', [AccountsController::class, 'store'])->name('account.create');
    Route::get('/accounts/{account}/edit', [AccountsController::class, 'edit'])->name('account.edit');
    Route::put('/accounts/{account}/edit', [AccountsController::class, 'update'])->name('account.update');
    Route::get('/accounts/{account}', [AccountsController::class, 'show'])->name('account');

    Route::get('/transactions', [TransactionsController::class, 'index'])->name('transactions');
    Route::get('/transactions/{account}', [TransactionsController::class, 'show'])->name('transactions.account');

    Route::get('/transferMoney', [TransferMoneyController::class, 'index'])->name('transferMoney');
    Route::post('/transferMoney', [TransferMoneyController::class, 'confirmation'])->name('transferMoney.confirm');
    Route::post('/transferMoney/confirm', [TransferMoneyController::class, 'transfer'])->name('transferMoney.transfer');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/codeConfirm', [CodeCardController::class, 'show'])->name('codeConfirm.show');
    Route::post('/codeConfirm', [CodeCardController::class, 'authenticate'])->name('authConfirm');
});

require __DIR__.'/auth.php';
