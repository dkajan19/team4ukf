<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->user_roles->rola;

        return view('profile', compact('role'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $user->update([
            'meno' => $request->meno,
            'priezvisko' => $request->priezvisko,
            'tel_cislo' => $request->tel_cislo,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Profil bol úspešne aktualizovaný.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Nesprávne staré heslo.']);
        }

        if (strlen($request->new_password) < 8) {
            return back()->withErrors(['new_password' => 'Heslo musí mať aspoň 8 znakov.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Heslo bolo úspešne zmenené.');
    }
}
