<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit account') }}{{$account->name ? ": $account->name" : ''}}
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
                        {{ $account->number }} ({{ number_format($account->balance / 100, 2) }} {{ $account->currency }})
                    </h2>
                    <form action="/accounts/{{$account->id}}/edit" method="post">
                        @csrf
                        @method('PUT')
                        <div class="inline-flex w-full">
                            <div class="w-full">
                                <label for="name" class="block font-medium text-sm text-gray-700">Name (optional)</label>
                                <input type="text" id="name" name="name" value="{{$account->name}}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                            </div>
                            <div class="ml-4">
                                <label for="currency" class="block font-medium text-sm text-gray-700">Currency</label>
                                <select id="currency" name="currency" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    @foreach($currencies as $currency)
                                        <option value="{{$currency->getId()}}" {{$account->currency==$currency->getId() ? 'selected':''}}>{{$currency->getId()}}</option>
                                    @endforeach
                                </select>
                            </div >
                        </div>
                        <div class="mt-6">
                            <input type="submit" value="Update account" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
