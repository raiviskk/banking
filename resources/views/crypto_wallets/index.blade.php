<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crypto Wallet') }}
        </h2>
    </x-slot>

    <div class="py-12 flex">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 ">
                    <table class="min-w-full border rounded-lg ">
                        <thead>
                        <tr>
                            <th class="border bg-gray-100 px-4 py-2">Crypto Code</th>
                            <th class="border bg-gray-100 px-4 py-2">Amount</th>
                            <th class="border bg-gray-100 px-4 py-2">Price Bought</th>
                            <th class="border bg-gray-100 px-4 py-2">Crypto Rate</th>
                            <th class="border bg-gray-100 px-4 py-2">% Change</th>
                            <th class="border bg-gray-100 px-4 py-2">Worth</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($cryptoWallets as $wallet)
                            <tr>
                                <td class="border px-4 py-2">{{ $wallet->crypto_code }}</td>
                                <td class="border px-4 py-2">{{ $wallet->amount }}</td>
                                <td class="border px-4 py-2">{{ $wallet->price_bought }}</td>
                                <td class="border px-4 py-2">{{ $wallet->crypto_rate }}</td>
                                <td class="border px-4 py-2">{{ number_format($wallet->percentage_change, 2) }}%</td>
                                <td class="border px-4 py-2">{{ $wallet->amount * $wallet->crypto_rate }} </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="border px-4 py-2 text-center">No Crypto available.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
