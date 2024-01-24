<x-app-layout>
    <x-slot name="header">
        <div class="mt-4">
            <h3 class="text-lg font-semibold">Crypto Accounts</h3>
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
                        <td colspan="2" class="border px-6 py-2 text-center">No Crypto accounts available.</td>
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
                            <h3 class="text-lg font-semibold mb-4">Buy Crypto</h3>
                            <form action="{{ route('crypto.buy') }}" method="post">
                                @csrf
                                <div class="mb-4">
                                    <label for="crypto_code" class="block text-sm font-medium text-gray-600">Crypto Code</label>
                                    <select name="crypto_code" id="crypto_code" class="mt-1 p-2 border rounded-md w-full">
                                        @foreach ($cryptoPrices as $crypto)
                                            <option value="{{ $crypto->code }}">{{ $crypto->code }} - EUR {{ $crypto->rate }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="amount" class="block text-sm font-medium text-gray-600">Amount</label>
                                    <input type="number"  name="amount" id="amount" class="mt-1 p-2 border rounded-md w-full">
                                </div>
                                <div class="mb-4">
                                    <button type="submit" class="bg-red-500 text-white rounded-md px-4 py-2 hover:bg-green-600 transition">Buy Crypto</button>
                                </div>
                            </form>
                        </div>

                        <!-- Sell Crypto Form -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-300 rounded-md hover:shadow-md transition">
                            <h3 class="text-lg font-semibold mb-4">Sell Crypto</h3>
                            <form action="{{ route('crypto.sell') }}" method="post">
                                @csrf
                                <div class="mb-4">
                                    <label for="crypto_wallet_id" class="block text-sm font-medium text-gray-600">Crypto Wallet</label>
                                    <select name="crypto_wallet_id" id="crypto_wallet_id" class="mt-1 p-2 border rounded-md w-full">
                                        @foreach ($cryptoWallets as $cryptoWallet)
                                            <option value="{{ $cryptoWallet->id }}">{{ $cryptoWallet->crypto_code }} - {{ $cryptoWallet->amount }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="amount_sell" class="block text-sm font-medium text-gray-600">Amount</label>
                                    <input type="number"  name="amount" id="amount_sell" class="mt-1 p-2 border rounded-md w-full">
                                </div>
                                <div class="mb-4">
                                    <button type="submit" class="bg-red-500 text-white rounded-md px-4 py-2 hover:bg-red-600 transition">Sell Crypto</button>
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
                <h3 class="text-lg font-semibold">Current Crypto Prices</h3>
            </div>

            <div class="grid grid-cols-4 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-8 gap-4 ">
                @forelse ($cryptoPrices as $crypto)
                    <div class="border bg-gray-100 px-2 py-2">
                        <p><strong>{{ $crypto->code }}</strong>  </p>
                        <p><strong>Price:</strong> {{ $crypto->rate }} <strong>Last Updated:</strong> {{ $crypto->updated_at }}</p>
                        <p></p>
                    </div>
                @empty
                    <div class="border px-4 py-2 text-center">No Crypto rates available.</div>
                @endforelse
            </div>
        </div>
    </div>


</x-app-layout>



