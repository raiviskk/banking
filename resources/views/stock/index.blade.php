<x-app-layout>
    <x-slot name="header">
        <div class="mt-4">
            <h3 class="text-lg font-semibold">Stock Accounts</h3>
            <table class="min-w-full border rounded-lg mt-2">
                <tbody>
                @forelse ($accounts as $account)
                    <tr>
                        <td class="border px-6 py-2 whitespace-nowrap">
                            {{ $account->formatted_balance }} {{ $account->currency->code }}
                        </td>
                        <td class="border px-6 py-2 whitespace-nowrap">
                            <a href="{{ route('accounts.show', $account->id) }}" class="text-blue-500">More Details</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="border px-6 py-2 text-center">No Stock accounts available.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Buy Crypto Form -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-300 rounded-md hover:shadow-md transition">
                            <h3 class="text-lg font-semibold mb-4">Buy Stock</h3>
                            <form action="{{ route('stock.buy') }}" method="post">
                                @csrf
                                <div class="mb-4">
                                    <label for="stock_symbol" class="block text-sm font-medium text-gray-600">Stock</label>
                                    <select name="stock_symbol" id="stock_symbol" class="mt-1 p-2 border rounded-md w-full">
                                        @foreach ($stockPrices as $stock)
                                            <option value="{{ $stock->symbol }}">{{ $stock->symbol }} - EUR {{ $stock->price }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="amount" class="block text-sm font-medium text-gray-600">Amount</label>
                                    <input type="number"  name="amount" id="amount" class="mt-1 p-2 border rounded-md w-full">
                                </div>
                                <div class="mb-4">
                                    <button type="submit" class="bg-red-500 text-white rounded-md px-4 py-2 hover:bg-green-600 transition">Buy Stock</button>
                                </div>
                            </form>
                        </div>

                        <!-- Sell Crypto Form -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-300 rounded-md hover:shadow-md transition">
                            <h3 class="text-lg font-semibold mb-4">Sell Stock</h3>
                            <form action="{{ route('stock.sell') }}" method="post">
                                @csrf
                                <div class="mb-4">
                                    <label for="stock_wallet_id" class="block text-sm font-medium text-gray-600">Stock Wallet</label>
                                    <select name="stock_wallet_id" id="stock_wallet_id" class="mt-1 p-2 border rounded-md w-full">
                                        @foreach ($stockWallets as $stockWallet)
                                            <option value="{{ $stockWallet->id }}">{{ $stockWallet->stock_symbol }} - {{ $stockWallet->amount }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="amount_sell" class="block text-sm font-medium text-gray-600">Amount</label>
                                    <input type="number"  name="amount" id="amount_sell" class="mt-1 p-2 border rounded-md w-full">
                                </div>
                                <div class="mb-4">
                                    <button type="submit" class="bg-red-500 text-white rounded-md px-4 py-2 hover:bg-red-600 transition">Sell Stock</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 ">
            <div class="mb-6">
                <h3 class="text-lg font-semibold">Current Stock Prices</h3>
            </div>

            <div class="grid grid-cols-4 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-8 gap-4 ">
                @forelse ($stockPrices as $stock)
                    <div class="border bg-gray-100 px-2 py-2">
                        <p><strong>{{ $stock->symbol }}</strong>  </p>
                        <p><strong>Price:</strong> {{ $stock->price }} <strong>Last Updated:</strong> {{ $stock->updated_at }}</p>
                        <p></p>
                    </div>
                @empty
                    <div class="border px-4 py-2 text-center">No Stock rates available.</div>
                @endforelse
            </div>
        </div>
    </div>


</x-app-layout>



