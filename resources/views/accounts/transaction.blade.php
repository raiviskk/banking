<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transfer Money') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('transaction.store') }}" method="post">
                        @csrf

                        <div class="mb-4">
                            <label for="from_account_id" class="block text-sm font-medium text-gray-600">From Account</label>
                            <select name="from_account_id" id="from_account_id" class="mt-1 p-2 border rounded-md w-full">
                                <!-- Add options for source accounts dynamically -->
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}">{{ $account->account_number }} ({{ $account->formatted_balance }} {{ $account->currency->code }} {{ $account->account_type }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="to_account_id" class="block text-sm font-medium text-gray-600">To Account</label>
                            <select name="to_account_id" id="to_account_id" class="mt-1 p-2 border rounded-md w-full">
                                <!-- Add options for destination accounts dynamically -->
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}">{{ $account->account_number }} ({{ $account->formatted_balance }} {{ $account->currency->code }} {{ $account->account_type }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-medium text-gray-600">Amount</label>
                            <input type="number" step="0.01" name="amount" id="amount" class="mt-1 p-2 border rounded-md w-full">
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-600">Description</label>
                            <textarea name="description" id="description" class="mt-1 p-2 border rounded-md w-full"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="reference_id" class="block text-sm font-medium text-gray-600">Reference ID</label>
                            <input type="text" name="reference_id" id="reference_id" class="mt-1 p-2 border rounded-md w-full">
                        </div>

                        <div class="mb-4">
                            <button type="submit" class="bg-amber-300 text-black rounded-md px-4 py-2">Transfer Money</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
