<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <h2 class="mt-2 w-full font-semibold text-xl text-gray-800 leading-tight pb-4">
                Cryptocurrency transaction history
            </h2>
            <div class="inline-flex">
                <input form="filter" type="text" id="search" name="search" value="{{$search}}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm ">
                <input form="filter" type="submit" value="Search" class="ml-1 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
            </div>
        </div>
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-row-reverse pb-4">
                        <form id="filter">
                            <div class="flex">
                                <select id="currency" name="account" class="ml-1 text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Account</option>
                                    @foreach($accounts as $account)
                                        @if($account->name)
                                            <option {{$filters['account']==$account->id? 'selected' : ''}} value="{{$account->id}}">{{$account->name}} ({{$account->number}})</option>
                                        @else
                                            <option {{$filters['account']==$account->id? 'selected' : ''}} value="{{$account->id}}">{{$account->number}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <select id="currency" name="currency" class="ml-1 text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Currency</option>
                                    @foreach($currencies as $currency)
                                        <option {{$filters['currency']==$currency->getId()? 'selected' : ''}} value="{{$currency->getId()}}">{{$currency->getId()}}</option>
                                    @endforeach
                                </select>
                                <p class="ml-1 pt-2">from:</p>
                                <input name="from" type="date" value="{{$filters['from']}}" class="ml-1 text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <p class="ml-1 pt-2">to:</p>
                                <input name="to" type="date" value="{{$filters['to']}}" class="ml-1 text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <input type="submit" value="Filter" class="ml-1 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <a href="{{route('cryptoTransactions')}}" class="ml-1 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Clear filtr</a>
                            </div>
                        </form>
                    </div>
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
                                <td class="px-4 py-2 text-center">
                                    <a href="/cryptocurrency/transactions/{{$transaction->account()->get()->first()->id}}">
                                        @if($transaction->account()->get()->first()->name)
                                            <span class="font-semibold whitespace-nowrap">{{$transaction->account()->get()->first()->name}}</span>
                                        @else
                                            <span class="font-semibold whitespace-nowrap">{{$transaction->account()->get()->first()->number}}</span>
                                        @endif
                                    </a>
                                </td>
                                <td class="px-4 py-2"><img src="{{$transaction->logo}}" alt="No image" class="inline-flex" width="40px"> <span class="font-semibold">{{$transaction->symbol}}</span> / {{$transaction->name}}</td>
                                <td class="px-4 py-2 text-center">{{$transaction->transaction}}</td>
                                <td class="px-4 py-2 text-center">{{$transaction->price/100}} {{$transaction->currency}}</td>
                                <td class="px-4 py-2 text-center">{{$transaction->amount}}</td>
                                <td class="px-4 py-2 text-center whitespace-nowrap {{$transaction->money<0 ? "text-red-600" : " text-green-600"}}">{{$transaction->money<0 ? '' : '+'}}{{$transaction->money/100}} {{$transaction->currency}}</td>
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
