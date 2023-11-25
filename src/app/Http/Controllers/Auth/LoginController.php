<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Overenie prešlo
            return redirect()->intended('/dashboard');
        }

        // Overenie zlyhalo
        return redirect()->route('login')->with('error', 'Neplatné prihlasovacie údaje. Skúste to prosím znova.');
    }
}
