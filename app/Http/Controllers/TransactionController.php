<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Currency;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;


class TransactionController extends Controller
{
    public function store(Request $request): RedirectResponse
    {

        $validatedData = $request->validate([
            'from_account_id' => 'required|exists:accounts,id',
            'to_account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string',
            'reference_id' => 'nullable|string',
        ]);

        $fromAccount = Account::findOrFail($validatedData['from_account_id']);
        $toAccount = Account::findOrFail($validatedData['to_account_id']);


        if ($fromAccount->user_id !== Auth::user()->id) {
            return redirect()->back();
        }


        if ($fromAccount->balance < $validatedData['amount']) {
            return redirect()->back();
        }


        $exchangeRate = $this->getExchangeRate($fromAccount->currency_code, $toAccount->currency_code);


        if ($exchangeRate === null) {
            return redirect()->back();
        }

        $convertedAmount = $validatedData['amount'] * $exchangeRate;

        $fromAccount->decrement('balance', $validatedData['amount']);
        $toAccount->increment('balance', $convertedAmount);

        $this->createTransaction(
            $fromAccount,
            'out',
            $validatedData['amount'],
            $validatedData['description'],
            $validatedData['reference_id']
        );

        $this->createTransaction(
            $toAccount,
            'in',
            $convertedAmount,
            $validatedData['description'],
            $validatedData['reference_id']
        );

        return redirect()->route('accounts.index')->with('success', 'Transfer successful.');
    }

    private function getExchangeRate(string $fromCurrency, string $toCurrency): ?float
    {
        if ($fromCurrency === $toCurrency) {
            return 1;
        }

        $fromRate = Currency::where('code', $fromCurrency)->value('rate');
        $toRate = Currency::where('code', $toCurrency)->value('rate');

        return $toRate / $fromRate;
    }

    private function createTransaction(
        Account $account,
        string  $direction,
        string  $amount,
        string  $description = null,
        string  $referenceId = null
    ): void
    {
        $account->transactions()->create([
            'user_id' => Auth::user()->id,
            'type' => 'transfer',
            'amount' => $amount,
            'direction' => $direction,
            'timestamp' => now(),
            'description' => $description,
            'reference_id' => $referenceId,
        ]);
    }

    public function create(): Application|View|Factory|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $accounts = Auth::user()->accounts;
        return view('accounts.transaction', compact('accounts'));
    }
}
