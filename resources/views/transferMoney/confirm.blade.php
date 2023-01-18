<x-guest-layout>
    @if(session()->has('message'))
        <h3 class="text-center text-xl text-red-600 leading-tight">
            {{session()->get('message')}}
        </h3>
    @endif
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Enter {{$codeNr<10 ? "0$codeNr" : "$codeNr"}}. code from your code card.
    </h2>
    <form method="POST" action="{{ route('transferMoney.transfer') }}" id="code">
        @csrf
        <div class="mt-3">
            <label for="code" class="block font-medium text-sm text-gray-700">Code</label>
            <input type="password" id="code" name="code" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>
        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ml-3">SEND</x-primary-button>
        </div>
    </form>
</x-guest-layout>
