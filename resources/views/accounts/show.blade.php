<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ __('Account Details') }}

        </h2>

    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <!--  Button -->
                <div class="p-6 justify-between items-center bg-gray-100 border-b border-gray-200">
                    <a href="{{ route('accounts.index') }}" class="text-blue-600 hover:underline">Back to Accounts</a>
                    <a href="{{ route('transaction.create') }}" class="text-blue-600 hover:underline ml-4">Transfer Money</a>
                </div>



                <!-- Account Information Section -->
                <div class="p-6 bg-gray-100 border-b border-gray-200">
                    <div>
                        <!-- Display Account Balance -->
                        <p class="text-gray-700 text-lg mb-2">
                            <span class="font-semibold">Balance:</span> {{ $account->formatted_balance }} {{ $account->currency->code }}
                        </p>

                        <!-- Display Account Number -->
                        <p class="text-gray-700 text-lg mb-2">
                            <span class="font-semibold">Account Number:</span> {{ $account->account_number }}
                        </p>
                        <!-- Display Account Type -->
                        <p class="text-gray-700 text-lg mb-2">
                            <span class="font-semibold">Account Type:</span> {{ $account->account_type }}
                        </p>
                        <!-- Display Account Status -->
                        <p class="text-lg font-semibold" style="color: {{ $account->is_active ? 'green' : 'red' }}">
                            <span class="font-semibold">Status:</span> {{ $account->is_active ? 'Active' : 'Inactive' }}
                        </p>
                        <!-- Add other details as needed -->
                    </div>
                </div>

                <!-- Transactions Section -->
                <!-- Transactions Section -->
                <div class="p-6 mt-4">
                    <h3 class="text-xl font-semibold mb-6">Transactions</h3>
                    <div class="border-t border-gray-300 mb-6"></div>
                    @if ($account->transactions->isEmpty())
                        <!-- No Transactions Found Message -->
                        <p class="text-gray-600">No transactions found for this account.</p>
                    @else
                        <!-- Display Transactions List -->
                        <div class="divide-y divide-gray-300">
                            @foreach ($account->transactions->reverse() as $transaction) <!-- Reverse the order of transactions -->
                            <div class="py-4">
                                <p class="text-gray-700 text-lg mb-1">
                                    <span class="font-semibold">Amount:</span> {{ $transaction->formatted_amount }} {{ $account->currency->code }}
                                    <span class="font-semibold">Direction:</span> {{ $transaction->direction }}
                                </p>
                                <p class="text-gray-600"><span class="font-semibold">When:</span> {{ $transaction->timestamp }}</p>
                                <p class="text-gray-600"><span class="font-semibold">Description:</span> {{ $transaction->description }}</p>
                                <p class="text-gray-500"><span class="font-semibold">Reference ID:</span> {{ $transaction->reference_id }}</p>
                            </div>
                            <!-- Light line between transactions -->
                            <div class="border-t border-gray-300"></div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
