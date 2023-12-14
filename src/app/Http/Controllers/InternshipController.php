<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Documents;
use App\Models\SchoolSubject;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InternshipController extends Controller
{
    public function index()
    {
        $praxe = Internship::all();
        $users = User::with('praxe')->get();
        $documents = Documents::with('internships')->get();
        $schoolSubjects = SchoolSubject::with('praxess')->get();
        $contracts = Contract::with('praxee')->get();

        $user = Auth::user();
        $role = $user->user_roles->rola;
        
        return view('prax.index', compact('praxe','users','documents','schoolSubjects','contracts','role'));
    }

    public function edit($id)
    {
        $user = User::with('user_roles')->find($id);
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

        $validatedData['password'] = bcrypt($request->input('password'));

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
            //'password' => 'required|string|max:255',
            'rola_pouzivatela_id' => 'required|exists:rola_pouzivatela,id',
        ]);

        //$validatedData['password'] = bcrypt($request->input('password'));

        User::whereId($id)->update($validatedData);

        return redirect()->route('user.index')->with('success', 'Používateľ bol úspešne aktualizovaný');
    }

    public function updatePassword(Request $request, $id)
    {
        $validatedData = $request->validate([
            'password' => 'required|string|max:255',
        ]);

        $validatedData['password'] = bcrypt($request->input('password'));

        User::whereId($id)->update($validatedData);

        return redirect()->route('user.index')->with('success', 'Používateľovo heslo bolo úspešne aktualizované');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'Používateľ bol úspešne odstránený.');
    }

}
