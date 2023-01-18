<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\CodeCard;
use App\Models\User;
use Illuminate\Auth\Events\Registered;;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Account;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): View
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $codeCard = new CodeCard();
        $codes=$codeCard->createCodes();
        $codeCard->user()->associate($user);
        $codeCard->save();

        $account = new Account();
        $account->fill([
            'number' => rand(100000000, 999999999),
        ]);
        $account->user()->associate($user);
        $account->save();
        $account->fill([
            'number' => "MeB-{$account->created_at->format('Ymd')}-{$account->id}-{$account->number}"
        ]);
        $account->save();

        event(new Registered($user));

        //Auth::login($user);

        return view('codeCard.codes', [
            'codes' => $codes
        ]);
    }
}
