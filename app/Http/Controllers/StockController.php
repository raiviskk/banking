<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Crypto;
use App\Models\CryptoWallet;
use App\Models\Stock;
use App\Models\StockWallet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class StockController extends Controller
{
    public function index():View
    {
        $stockPrices = Stock::all();
        $accounts = Account::where('user_id', auth()->id())->where('account_type', 'Investment')->get();
        $stockWallets = StockWallet::where('user_id', auth()->id())->get();

        return view('stock.index', compact('stockPrices', 'accounts', 'stockWallets'));
    }

    public function buy(Request $request): RedirectResponse
    {
        $request->validate([
//            'stock_symbol' => 'required|exists:stock_symbol',
            'amount' => 'required|numeric|min:0.01',
        ]);


        $stock = Stock::where('symbol', $request->stock_symbol)->first();

        $totalCost = $stock->price * $request->amount * 100;

        $stockAccount = Account::where('user_id', auth()->id())
            ->where('account_type', 'Investment')
            ->first();

        if ($stockAccount->balance >= $totalCost) {

            $stockAccount->decrement('balance', $totalCost );

            $this->createTransaction(
                $stockAccount,
                'out',
                $totalCost,
                'Stock purchase'
            );

            StockWallet::create([
                'user_id' => Auth::user()->id,
                'stock_symbol' => $request->stock_symbol,
                'amount' => $request->amount,
                'price_bought' => $stock->price,
                'current_price' => $stock->price,
            ]);

            return redirect()->back();
        }

        return redirect()->back();
    }

    private function createTransaction(
        Account $account,
        string  $direction,
        string  $amount,
        string  $description = null
    ): void
    {
        $account->transactions()->create([
            'user_id' => Auth::user()->id,
            'type' => 'transfer',
            'amount' => $amount,
            'direction' => $direction,
            'timestamp' => now(),
            'description' => $description,
        ]);
    }

    public function sell(Request $request): RedirectResponse
    {
        $request->validate([
            'stock_wallet_id' => 'required|exists:stock_wallets,id',
            'amount' => 'required|numeric|min:0.0000000001',
        ]);

        $stockWallet = StockWallet::findOrFail($request->input('stock_wallet_id'));

        if ($stockWallet->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        if ($stockWallet->amount < $request->input('amount')) {
            return redirect()->back()->with('error', 'Insufficient crypto balance.');
        }

        $stock = Stock::where('symbol', $stockWallet->stock_symbol)->first();
        $currentRate = $stock->price;

        $amountInUserCurrency = $request->input('amount') * $currentRate * 100;

        $stockWallet->decrement('amount', $request->input('amount'));

        $stockAccount = Account::where('user_id', auth()->id())
            ->where('account_type', 'Investment')
            ->first();

        $stockAccount->increment('balance', $amountInUserCurrency );

        $this->createTransaction(
            $stockAccount,
            'in',
            $amountInUserCurrency,
            'Stock sale'
        );

        return redirect()->back();
    }
}
