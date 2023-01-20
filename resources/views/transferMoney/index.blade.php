<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Transfer money
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <form action="{{route('transferMoney.confirm')}}" method="post">
                        @csrf
                        <div class="w-full">
                            <div class="pt-4">
                                <label for="senderAccount" class="block font-medium text-sm text-gray-700">Chose account</label>
                                <select id="senderAccount" name="senderAccount" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                    @foreach($accounts as $account)
                                        <option value="{{$account->number}}">
                                            @if($account->name)
                                                <p class="inline-flex">{{$account->name}} ({{$account->number}}) </p>
                                            @else
                                                <p class="inline-flex">{{$account->number}}</p>
                                            @endif
                                            <p class="inline-flex">({{ number_format($account->balance / 100, 2) }} {{ $account->currency }})</p>
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('senderAccount')" class="mt-2" />
                            </div>
                            <div class="pt-4">
                                <label for="money" class="block font-medium text-sm text-gray-700">Amount</label>
                                <input type="number" id="amount" name="money" min="0.01" step="0.01" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                <x-input-error :messages="$errors->get('money')" class="mt-2" />
                            </div>
                            <div class="pt-4">
                                <label for="receiverAccount" class="block font-medium text-sm text-gray-700">Transfer to</label>
                                <input type="text" id="receiverAccount" name="receiverAccount" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                <x-input-error :messages="$errors->get('receiverAccount')" class="mt-2" />
                            </div>
                        </div >
                        <div class="mt-6">
                            <input type="submit" value="Confirm with code card" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
