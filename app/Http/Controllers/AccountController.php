<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index(): View|Application|Factory|string|\Illuminate\Contracts\Foundation\Application
    {
            $accounts = Auth::user()->accounts;
            return view('accounts.index', compact('accounts'));
    }

    public function show(Account $account): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('accounts.show', compact('account'));
    }

    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('accounts.create');
    }

    public function store(Request $request): RedirectResponse
    {

        $validatedData = $request->validate([
            'account_type' => 'required|exists:account_types,type',
            'currency_code' => 'required|exists:currencies,code',

        ]);


        $accountNumber = random_int(111111111, 999999999);
        $balance = 0;


        Account::create([
            'user_id' => auth()->user()->id,
            'account_type' => $validatedData['account_type'],
            'balance' => $balance,
            'currency_code' => $request->input('currency_code'),
            'account_number' => $accountNumber,
            'opened_at' => now(),
        ]);


        return redirect()->route('accounts.index');
    }

}
