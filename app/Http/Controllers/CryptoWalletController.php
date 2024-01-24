<?php

namespace App\Http\Controllers;

use App\Models\Crypto;
use App\Models\CryptoWallet;
use Illuminate\Contracts\View\View;



class CryptoWalletController extends Controller
{
    public function index(): View
    {
        $cryptoWallets = CryptoWallet::where('user_id', auth()->id())->get();

        foreach ($cryptoWallets as $wallet) {
            $crypto = Crypto::where('code', $wallet->crypto_code)->first();
            $wallet->crypto_rate = $crypto->rate;
            $wallet->percentage_change = (($crypto->rate - $wallet->price_bought) / $wallet->price_bought) * 100;
        }

        return view('crypto_wallets.index', compact('cryptoWallets'));
    }
}
