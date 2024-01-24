<?php

namespace App\Http\Controllers;

use App\Models\Crypto;
use App\Models\CryptoWallet;
use App\Models\Stock;
use App\Models\StockWallet;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class StockWalletController extends Controller
{
    public function index(): View
    {
        $stockWallets = StockWallet::where('user_id', auth()->id())->get();

        foreach ($stockWallets as $wallet) {
            $stock = Stock::where('symbol', $wallet->stock_symbol)->first();
            $wallet->stock_price = $stock->price;
            $wallet->percentage_change = (($stock->price - $wallet->price_bought) / $wallet->price_bought) * 100;
        }

        return view('stock_wallets.index', compact('stockWallets'));
    }
}
