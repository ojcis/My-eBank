<x-app-layout>
    <x-slot name="header">
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-center font-semibold text-xl text-gray-800 leading-tight mb-6">
                        {{ __('Your transaction history')}}
                    </h2>
                    <table class="table-fixed w-full">
                        <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">Nr</th>
                            <th class="px-4 py-2">Your account</th>
                            <th class="px-4 py-2">Money amount</th>
                            <th class="px-4 py-2">Time</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($transactions as $i => $transaction)
                            <tr class="{{ $i % 2 == 0 ? '' : 'bg-gray-100'}} text-center">
                                <td class="px-4 py-2">{{$i+1}}.</td>
                                <td class="px-4 py-2">{{$transaction->account_id}}.</td>
                                <td class="px-4 py-2 {{$transaction->money<0 ? "text-red-600" : " text-green-600"}}">{{$transaction->money}} {{$transaction->currency}}</td>
                                <td class="px-4 py-2">{{$transaction->created_at->format('d/m/Y')}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
