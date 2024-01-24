<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Crypto;
use App\Models\CryptoWallet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class CryptoController extends Controller
{
    public function index():View
    {
        $cryptoPrices = Crypto::all();
        $accounts = Account::where('user_id', auth()->id())->where('account_type', 'crypto')->get();
        $cryptoWallets = CryptoWallet::where('user_id', auth()->id())->get();

        return view('crypto.index', compact('cryptoPrices', 'accounts', 'cryptoWallets'));
    }

    public function buy(Request $request): RedirectResponse
    {
        $request->validate([
            'crypto_code' => 'required|exists:cryptos,code',
            'amount' => 'required|numeric|min:0.01',
        ]);


        $crypto = Crypto::where('code', $request->crypto_code)->first();

        $totalCost = $crypto->rate * $request->amount * 100;

        $cryptoAccount = Account::where('user_id', auth()->id())
            ->where('account_type', 'Crypto')
            ->first();

        if ($cryptoAccount->balance >= $totalCost) {

            $cryptoAccount->decrement('balance', $totalCost );

            $this->createTransaction(
                $cryptoAccount,
                'out',
                $totalCost,
                'Crypto purchase'
            );

            CryptoWallet::create([
                'user_id' => Auth::user()->id,
                'crypto_code' => $request->crypto_code,
                'amount' => $request->amount,
                'price_bought' => $crypto->rate,
                'current_price' => $crypto->rate,
            ]);

            return redirect()->back()->with('success', 'Crypto bought successfully.');
        }

        return redirect()->back()->with('error', 'Insufficient funds to buy crypto.');
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
            'crypto_wallet_id' => 'required|exists:crypto_wallets,id',
            'amount' => 'required|numeric|min:0.0000000001',
        ]);

        $cryptoWallet = CryptoWallet::findOrFail($request->input('crypto_wallet_id'));

        if ($cryptoWallet->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        if ($cryptoWallet->amount < $request->input('amount')) {
            return redirect()->back()->with('error', 'Insufficient crypto balance.');
        }

        $crypto = Crypto::where('code', $cryptoWallet->crypto_code)->first();
        $currentRate = $crypto->rate;

        $amountInUserCurrency = $request->input('amount') * $currentRate * 100;

        $cryptoWallet->decrement('amount', $request->input('amount'));

        $cryptoAccount = Account::where('user_id', auth()->id())
            ->where('account_type', 'Crypto')
            ->first();

        $cryptoAccount->increment('balance', $amountInUserCurrency );

        $this->createTransaction(
            $cryptoAccount,
            'in',
            $amountInUserCurrency,
            'Crypto sale'
        );

        return redirect()->back();
    }

}
