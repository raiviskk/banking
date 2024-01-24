<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Account') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-white border-b border-gray-200">
                    <form action="{{ route('accounts.store') }}" method="post" class="space-y-4">
                        @csrf

                        <div>
                            <label for="account_type" class="block text-sm font-medium text-gray-600">Account Type</label>
                            <select name="account_type" id="account_type" class="mt-1 p-2 border rounded-md w-full">
                                <!-- Add options for account types dynamically if needed -->
                                <option value="Debit">Debit</option>
                                <option value="Saving">Saving</option>
                            </select>
                        </div>

                        <div>
                            <label for="currency_code" class="block text-sm font-medium text-gray-600">Currency</label>
                            <select name="currency_code" id="currency_code" class="mt-1 p-2 border rounded-md w-full">
                                <!-- Add options for currencies dynamically if needed -->
                                <option value="USD">US Dollar</option>
                                <option value="EUR">Euro</option>
                                <option value="JPY">Japanese Yen</option>
                                <option value="GBP">British Pound Sterling</option>
                                <option value="CHF">Swiss Franc</option>
                            </select>
                        </div>

                        <!-- Add other form fields here -->

                        <div>
                            <button type="submit" class="bg-amber-300 text-black rounded-md px-4 py-2">Create Account</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
