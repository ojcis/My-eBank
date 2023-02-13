<x-app-layout>
    <x-slot name="header">
        <div class="inline-flex">
            <h2 class="font-semibold text-xl text-green-700 leading-tight">
                {{session()->get('success')}}
            </h2>
            <h3 class="text-center text-xl text-red-600 leading-tight">
                {{session()->get('message')}}
            </h3>
        </div>
    </x-slot>
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg w-full">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight pb-5">
                        {{$account->name ? "$account->name" : 'Your account'}}
                    </h2>
                    <table class="table-fixed w-full">
                        <thead>
                        <tr class="bg-gray-100">
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
                    <div class="pt-8">
                        <a type="button" href="/accounts/{{$account->id}}/edit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Edit this account
                        </a>
                        <form action="/accounts/{{$account->id}}/delete" method="post" class="inline-flex">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Delete this account
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($cryptocurrencies)
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg w-full">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight pb-5">
                        Your Cryptocurrencies
                    </h2>
                    <table class="table-auto w-full">
                        <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">Cryptocurrency</th>
                            <th class="px-4 py-2">Price</th>
                            <th class="px-4 py-2">Amount</th>
                            <th class="px-4 py-2">Total value</th>
                            <th class="px-4 py-2">Purchased</th>
                            <th class="px-4 py-2">Sell</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cryptocurrencies as $i => $cryptocurrency)
                            <tr class="{{ $i % 2 == 0 ? '' : 'bg-gray-100'}}">
                                <td class="px-4 py-2"><img src="{{$cryptocurrency->logo}}" alt="no image" width="40px" class="inline-flex"> <span class="font-semibold">{{$cryptocurrency->symbol}}</span> / {{$cryptocurrency->name}}</td>
                                <td class="px-4 py-2 text-center">{{($cryptocurrency->price/100)}} {{$cryptocurrency->currency}}</td>
                                <td class="px-4 py-2 text-center">{{($cryptocurrency->amount/1000)}}</td>
                                <td class="px-4 py-2 text-center">{{number_format((($cryptocurrency->amount/1000)*$cryptocurrency->price)/100, 2)}} {{$cryptocurrency->currency}}</td>
                                <td class="px-4 py-2 text-center">{{($cryptocurrency->created_at->format('H:i d/m/Y'))}}</td>
                                <td class="px-4 py-2 text-center"><a href="/cryptocurrencies/{{$cryptocurrency->id}}/sell" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">sell</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>
