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
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
                        {{ __('Your accounts')}}
                    </h2>
                    <table class="table-fixed w-full">
                        <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-left">Account</th>
                            <th class="px-4 py-2 sm:text-right">Balance</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($accounts as $i => $account)
                            <tr class="{{ $i % 2 == 0 ? '' : 'bg-gray-100'}}">
                                <td class="px-4 py-2">
                                    <a href="/accounts/{{$account->id}}">
                                        @if($account->name)
                                            <p class="inline-flex" style="font-size: 18px">{{$account->name}} </p><p class="inline-flex text-xs pl-3">({{$account->number}})</p>
                                        @else
                                            {{$account->number}}
                                        @endif
                                    </a>
                                </td>
                                <td class="px-4 py-2 sm:text-right">
                                    {{ number_format($account->balance / 100, 2) }} {{ $account->currency }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="pt-8">
                        <a type="button" href="/accounts/create" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Create new account
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
