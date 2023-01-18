<?php

namespace App\Http\Controllers;

use App\Models\CodeCard;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class CodeCardController extends Controller
{
    public function show(): View
    {
        Session::put('codeNr', rand(1,env('CODE_COUNT')));
        return view('codeCard.confirm', [
            'codeNr' => Session::get('codeNr'),
            'route' => Session::get('route')
        ]);
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'string', 'max:8', 'min:8'],
        ]);
        $codeNr = Session::get('codeNr');
        Session::forget('codeNr');
        $code=CodeCard::where('user_id', Auth::id())->first()->$codeNr;
        if (! Hash::check($request->code, $code)){
            return Redirect::route('codeConfirm.show')->with('message', 'Wrong code!');
        }
        Session::put('auth2', true);
        return redirect()->intended(RouteServiceProvider::HOME);
    }


}
