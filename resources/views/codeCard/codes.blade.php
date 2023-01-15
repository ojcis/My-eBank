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
    <div class="inline-flex">
        <a type="button" href="{{ route('login') }}" class="mt-6 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Authorize</a>
        <p class="inline-flex mt-6 ml-4">Keep your code card safe! You will need it to authorize.</p>
    </div>
</x-guest-layout>
