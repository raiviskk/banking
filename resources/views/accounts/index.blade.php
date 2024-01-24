<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your Accounts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($accounts->isEmpty())
                        <p class="text-gray-600">No accounts found.</p>
                    @else
                        @php
                            $accountTypes = $accounts->pluck('account_type')->unique();
                        @endphp
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach ($accountTypes as $accountType)
                                <div class="mt-4 border rounded-md p-4">
                                    <h2 class="text-xl font-semibold">{{ $accountType }} Accounts</h2>
                                    <table class="min-w-full divide-y divide-gray-200 mt-2">
                                        <thead>
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                BALANCE
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                ACCOUNT NUMBER
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                ACTIONS
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($accounts->where('account_type', $accountType) as $account)
                                            <tr>
                                                <td class="px-6 py-2 whitespace-nowrap">
                                                    {{ $account->formatted_balance }} {{ $account->currency->code }}
                                                </td>
                                                <td class="px-6 py-2 whitespace-nowrap">
                                                    {{ $account->account_number }}
                                                </td>
                                                <td class="px-6 py-2 whitespace-nowrap">
                                                    <a href="{{ route('accounts.show', $account->id) }}" class="text-blue-500">More Details</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
