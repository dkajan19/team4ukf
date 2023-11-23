<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return redirect('/dashboard'); // Presmerovanie na dashboard, ak je už používateľ prihlásený
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'meno' => 'required|string|max:255',
            'priezvisko' => 'required|string|max:255',
            'tel_cislo' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'meno' => $request->meno,
            'priezvisko' => $request->priezvisko,
            'tel_cislo' => $request->tel_cislo,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registration successful. You can now login.');
    }
}
