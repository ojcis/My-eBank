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
                    <table class="table-auto w-full">
                        <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">Cryptocurrency</th>
                            <th class="px-4 py-2">Price</th>
                            <th class="px-4 py-2">1h</th>
                            <th class="px-4 py-2">24h</th>
                            <th class="px-4 py-2">7d</th>
                            <th class="px-4 py-2">Volume 24h</th>
                            <th class="px-4 py-2">Circulating Supply</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-4 py-2"><img src="{{$cryptocurrency->getLogo()}}" alt="No image" class="inline-flex" width="60px"> <span class="font-semibold">{{$cryptocurrency->getSymbol()}}</span> / {{$cryptocurrency->getName()}}</td>
                                <td class="px-4 py-2 text-center">{{number_format($cryptocurrency->getPrice(),2)}} {{$cryptocurrency->getCurrency()}}</td>
                                <td class="px-4 py-2 text-center {{$cryptocurrency->getPercentChange1h()<0 ? 'text-red-700' : 'text-green-700'}}">{{number_format($cryptocurrency->getPercentChange1h(),2)}}%</td>
                                <td class="px-4 py-2 text-center {{$cryptocurrency->getPercentChange24h()<0 ? 'text-red-700' : 'text-green-700'}}">{{number_format($cryptocurrency->getPercentChange24h(),2)}}%</td>
                                <td class="px-4 py-2 text-center {{$cryptocurrency->getPercentChange7d()<0 ? 'text-red-700' : 'text-green-700'}}">{{number_format($cryptocurrency->getPercentChange7d(),2)}}%</td>
                                <td class="px-4 py-2 text-center whitespace-nowrap">{{number_format($cryptocurrency->getVolume24h())}} {{$cryptocurrency->getCurrency()}}</td>
                                <td class="px-4 py-2 text-center">{{$cryptocurrency->getCirculatingSupply()}}</td>
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
                        Buy
                    </h2>
                    <form action="/cryptocurrencies/{{$cryptocurrency->getSymbol()}}" method="post">
                        @csrf
                        <div class="inline-flex w-full">
                            <div class="pt-4 w-full pr-4">
                                <label for="account" class="block font-medium text-sm text-gray-700">Chose account</label>
                                <select id="account" name="account" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                    @foreach($accounts as $account)
                                        <option value="{{$account->id}}">
                                            @if($account->name)
                                                {{$account->name}}
                                            @else
                                                {{$account->number}}
                                            @endif
                                            ({{ number_format($account->balance / 100, 2) }} {{ $account->currency }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="session()->get('message')" class="mt-2" />
                            </div>
                            <div class="pt-4">
                                <label for="amount" class="block font-medium text-sm text-gray-700">Amount</label>
                                <input type="number" id="amount" name="amount" min="0.001" step="0.001" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                            </div>
                        </div>
                        <div class="mt-6">
                            <input type="submit" value="Confirm with code card" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
