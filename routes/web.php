<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CryptoController;
use App\Http\Controllers\CryptoWalletController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockWalletController;
use App\Http\Controllers\TransactionController;
use App\Models\StockWallet;
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

Route::get('/', function () {
    return redirect('/register');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
    Route::get('/accounts/create', [AccountController::class, 'create'])->name('accounts.create');
    Route::get('/accounts/{account}', [AccountController::class,'show'])->name('accounts.show');
    Route::post('/accounts', [AccountController::class, 'store'])->name('accounts.store');
    Route::get('/transaction', [TransactionController::class, 'create'])->name('transaction.create');
    Route::post('/transaction', [TransactionController::class, 'store'])->name('transaction.store');
    Route::get('/crypto-prices', [CryptoController::class, 'index'])->name('crypto.prices');
    Route::post('/crypto-prices', [CryptoController::class, 'buy'])->name('crypto.buy');
    Route::get('/crypto-wallet', [CryptoWalletController::class, 'index'])->name('crypto.wallets');
    Route::post('/crypto-wallet', [CryptoController::class, 'sell'])->name('crypto.sell');
    Route::get('/stock', [StockController::class, 'index'])->name('stock.prices');
    Route::post('/stock', [StockController::class, 'buy'])->name('stock.buy');
    Route::get('/stock-wallet', [StockWalletController::class, 'index'])->name('stock.wallets');
    Route::post('/stock-wallet', [StockController::class, 'sell'])->name('stock.sell');
});



require __DIR__.'/auth.php';
