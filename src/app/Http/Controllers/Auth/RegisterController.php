<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'meno' => 'required|string|max:255',
            'priezvisko' => 'required|string|max:255',
            'tel_cislo' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pouzivatel',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Kontrola, či email už existuje
        if (User::where('email', $request->email)->exists()) {
            return back()->withErrors(['email' => 'Táto e-mailová adresa je už zaregistrovaná.']);
        }

        User::create([
            'meno' => $request->meno,
            'priezvisko' => $request->priezvisko,
            'tel_cislo' => $request->tel_cislo,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registrácia úspešná. Teraz sa môžete prihlásiť.');
    }
}
