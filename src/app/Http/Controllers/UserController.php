<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('user_role')->get();
        $user_roles = UserRole::all();
        
        return view('user.index', compact('users','user_roles'));
    }

    public function edit($id)
    {
        $user = User::with('user_role')->find($id);
        $user_roles = UserRole::all();

        return view('user.edit', compact('user', 'user_roles'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('user.show', compact('user'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'meno' => 'required|string|max:255',
            'priezvisko' => 'required|string|max:255',
            'tel_cislo' => 'required|string|max:20',
            'email' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'rola_pouzivatela_id' => 'required|exists:rola_pouzivatela,id',
        ]);

        User::create($validatedData);

        return redirect()->route('user.index')->with('success', 'Používateľ bol úspešne pridaný.');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'meno' => 'required|string|max:255',
            'priezvisko' => 'required|string|max:255',
            'tel_cislo' => 'required|string|max:20',
            'email' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'rola_pouzivatela_id' => 'required|exists:rola_pouzivatela,id',
        ]);

        User::whereId($id)->update($validatedData);

        return redirect()->route('user.index')->with('success', 'Používateľ bol úspešne aktualizovaný');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')
                        ->with('success', 'Používateľ bol úspešne odstránený.');
    }
}
