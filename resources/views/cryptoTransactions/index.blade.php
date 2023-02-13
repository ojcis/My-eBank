<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-700 leading-tight">
            {{session()->get('success')}}
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight pb-4">
                        {{ __('Your cryptocurrency history')}}
                    </h2>
                    <table class="table-auto w-full">
                        <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">Account</th>
                            <th class="px-4 py-2">Cryptocurrency</th>
                            <th class="px-4 py-2">Transaction</th>
                            <th class="px-4 py-2">Price</th>
                            <th class="px-4 py-2">Amount</th>
                            <th class="px-4 py-2">Money</th>
                            <th class="px-4 py-2">Time</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($transactions as $i => $transaction)
                            <tr class="{{ $i % 2 == 0 ? '' : 'bg-gray-100'}}">
                                <td class="px-4 py-2 text-center"><a href="/cryptocurrency/transactions/{{$transaction->account()->get()->first()->id}}">{{$transaction->account()->get()->first()->number}}</a></td>
                                <td class="px-4 py-2"><img src="{{$transaction->logo}}" alt="No image" class="inline-flex" width="40px"> <span class="font-semibold">{{$transaction->symbol}}</span> / {{$transaction->name}}</td>
                                <td class="px-4 py-2 text-center">{{$transaction->transaction}}</td>
                                <td class="px-4 py-2 text-center">{{$transaction->price/100}} {{$transaction->currency}}</td>
                                <td class="px-4 py-2 text-center">{{$transaction->amount/1000}}</td>
                                <td class="px-4 py-2 text-center {{$transaction->money<0 ? "text-red-600" : " text-green-600"}}">{{$transaction->money<0 ? '' : '+'}}{{$transaction->money/100}} {{$transaction->currency}}</td>
                                <td class="px-4 py-2 text-center">{{$transaction->created_at->format('H:i d/m/Y')}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="pt-4 flex justify-end">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
