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
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight pb-5">
                       Your cryptocurrency
                    </h2>
                    <table class="table-auto w-full">
                        <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">Cryptocurrency</th>
                            <th class="px-4 py-2">Price</th>
                            <th class="px-4 py-2">Amount</th>
                            <th class="px-4 py-2">Total price</th>
                            <th class="px-4 py-2">Price now</th>
                            <th class="px-4 py-2">Total price now</th>
                            <th class="px-4 py-2">Profit</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-4 py-2"><img src="{{$cryptoCoin->logo}}" alt="no image" width="60px" class="inline-flex"> <span class="font-semibold">{{$cryptoCoin->symbol}}</span> / {{$cryptoCoin->name}}</td>
                                <td class="px-4 py-2 text-center">{{number_format($cryptoCoin->price/100, 2)}} {{$cryptoCoin->currency}}</td>
                                <td class="px-4 py-2 text-center">{{($cryptoCoin->amount/1000)}}</td>
                                <td class="px-4 py-2 text-center">{{number_format((($cryptoCoin->amount/1000)*$cryptoCoin->price)/100, 2)}} {{$cryptoCoin->currency}}</td>
                                <td class="px-4 py-2 text-center">{{number_format($priceNow/100, 2)}} {{$cryptoCoin->currency}}</td>
                                <td class="px-4 py-2 text-center">{{number_format((($cryptoCoin->amount/1000)*$priceNow)/100, 2)}} {{$cryptoCoin->currency}}</td>
                                <td class="px-4 py-2 text-center {{((($cryptoCoin->amount/1000)*$priceNow)-(($cryptoCoin->amount/1000)*$cryptoCoin->price))>0 ? "text-green-600" : "text-red-600"}}">
                                    {{((($cryptoCoin->amount/1000)*$priceNow)-(($cryptoCoin->amount/1000)*$cryptoCoin->price))>0 ? '+' : ''}}
                                    {{number_format(((($cryptoCoin->amount/1000)*$priceNow)-(($cryptoCoin->amount/1000)*$cryptoCoin->price))/100, 2)}} {{$cryptoCoin->currency}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Sell
                    </h2>
                    <form action="/cryptocurrencies/{{$cryptoCoin->id}}/sell" method="post">
                        @csrf
                        <div class="inline-flex w-full">
                            <div class="pt-4 w-full">
                                <label for="amount" class="block font-medium text-sm text-gray-700">Amount</label>
                                <input type="number" id="amount" name="amount" min="0.001" step="0.001" max="{{$cryptoCoin->amount/1000}}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                            </div>
                        </div>
                        <div class="pt-6">
                            <input type="submit" value="Confirm with code card" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
