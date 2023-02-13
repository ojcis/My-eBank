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
                        Cryptocurrencies
                    </h2>
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
                        @foreach($cryptocurrencies as $i => $cryptocurrency)
                            <tr class="{{ $i % 2 == 0 ? '' : 'bg-gray-100'}}">
                                <td class="px-4 py-2"><a href="/cryptocurrencies/{{$cryptocurrency->getSymbol()}}"><span class="font-semibold">{{$cryptocurrency->getSymbol()}}</span> / {{$cryptocurrency->getName()}}</a></td>
                                <td class="px-4 py-2 text-center">{{number_format($cryptocurrency->getPrice(),2)}} {{$cryptocurrency->getCurrency()}}</td>
                                <td class="px-4 py-2 text-center {{$cryptocurrency->getPercentChange1h()<0 ? 'text-red-700' : 'text-green-700'}}">{{$cryptocurrency->getPercentChange1h()>0 ? '+' : ''}}{{number_format($cryptocurrency->getPercentChange1h(),2)}}%</td>
                                <td class="px-4 py-2 text-center {{$cryptocurrency->getPercentChange24h()<0 ? 'text-red-700' : 'text-green-700'}}">{{$cryptocurrency->getPercentChange24h()>0 ? '+' : ''}}{{number_format($cryptocurrency->getPercentChange24h(),2)}}%</td>
                                <td class="px-4 py-2 text-center {{$cryptocurrency->getPercentChange7d()<0 ? 'text-red-700' : 'text-green-700'}}">{{$cryptocurrency->getPercentChange7d()>0 ? '+' : ''}}{{number_format($cryptocurrency->getPercentChange7d(),2)}}%</td>
                                <td class="px-4 py-2 text-center whitespace-nowrap">{{number_format($cryptocurrency->getVolume24h())}} {{$cryptocurrency->getCurrency()}}</td>
                                <td class="px-4 py-2 text-center">{{$cryptocurrency->getCirculatingSupply()}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="pt-4 flex justify-end">
                        {{$cryptocurrencies->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
