<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Account') }}{{$account->name ? ": $account->name" : ''}}
        </h2>
    </x-slot>
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg w-full">
                <div class="p-6 text-gray-900">
                    <table class="table-fixed w-full">
                        <thead>
                        <tr>
                            <th class="px-4 py-2 text-left">Account number</th>
                            <th class="px-4 py-2 sm:text-right">Balance</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="px-4 py-2 text-left">{{$account->number}}</td>
                            <td class="px-4 py-2 sm:text-right">{{ number_format($account->balance / 100, 2) }} {{ $account->currency }}</td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="mt-2">
                        <a type="button" href="/accounts/{{$account->id}}/edit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Edit this account</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
