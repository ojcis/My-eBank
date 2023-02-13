<x-guest-layout>
    <h2 class="font-semibold text-center text-gray-800 leading-tight mb-4">
        Your account is registered successfully!
    </h2>
    <h1 class="font-semibold text-xl text-center text-gray-800 leading-tight mb-4">
        {{ __('Code card') }}
    </h1>
    @foreach($codes as $key=>$code)
        <p style="white-space: nowrap" class="inline-flex ml-4">{{$key<10 ? "0$key" : "$key"}}. {{$code}}</p>
    @endforeach
    <div class="flex items-center justify-end mt-4">
        <p>
            Keep your code card safe, this is only time you will see this! You will need it to authorize and confirm transactions.
        </p>
        <a type="button" href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
            Authorize
        </a>
    </div>
</x-guest-layout>
