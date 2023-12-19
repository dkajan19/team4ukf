<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Documents;
use App\Models\SchoolSubject;
use App\Models\Contract;
use App\Models\Internship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InternshipController extends Controller
{
    public function index()
    {
        $praxe = Internship::all();
        $users = User::all();
        $userr = $users->first();
        $praxInternships = $userr->prax;
        $praxeInternships = $userr->praxe;
        $praxeaInternships = $userr->praxea;
        $praxebInternships = $userr->praxeb;
        $documents = Documents::with('internships')->get();
        $schoolSubjects = SchoolSubject::with('praxess')->get();
        $contracts = Contract::with('praxee')->get();

        $user = Auth::user();
        $role = $user->user_roles->rola;

        return view('prax.index', compact('praxe', 'praxInternships', 'praxeInternships', 'praxeaInternships', 'praxebInternships', 'documents', 'schoolSubjects', 'contracts', 'role', 'users'));
    }

    public function edit($id)
    {
        $prax = Internship::findOrFail($id);
        $users = User::all();
        $documents = Documents::all();
        $schoolSubjects = SchoolSubject::all();
        $contracts = Contract::all();
       
        return view('prax.edit', compact('prax', 'users', 'documents', 'schoolSubjects', 'contracts'));
    }

    public function show($id)
    {
        $prax = Internship::findOrFail($id);
        return view('prax.show', compact('prax'));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
            'popis_praxe' => 'required|string|max:255',
            'datum_zaciatku' => 'required|date|date_format:Y-m-d',
            'datum_konca'=> 'required|date|date_format:Y-m-d',
            'aktualny_stav'=> 'nullable|string|max:255',
            'student_id' => 'required|exists:pouzivatel,id',
            'veduci_pracoviska_id'=> 'required|exists:pouzivatel,id',
            'pracovnik_fpvai_id'=> 'required|exists:pouzivatel,id',
            'kontaktna_osoba_id'=> 'required|exists:pouzivatel,id',
            'predmety_id' => 'required|exists:predmety,id',
            'dokumenty_id'=> 'required|exists:dokumenty,id',
            'zmluva_id'=> 'required|exists:zmluva,id',
        ]);
        Internship::create($validatedData);
        return redirect()->route('prax.index')->with('success', 'Prax bola úspešne pridaná.');
    } catch (\Exception $e) {
        return redirect()->route('prax.index')->with('error', 'Chyba pri vytváraní praxe: ' . $e->getMessage());
    }
    }

    public function update(Request $request, $id)
    {
        try{
            $validatedData = $request->validate([
            'popis_praxe' => 'required|string|max:255',
            'datum_zaciatku' => 'required|date|date_format:Y-m-d',
            'datum_konca'=> 'required|date|date_format:Y-m-d',
            'aktualny_stav'=> 'nullable|string|max:255',
            'student_id' => 'required|exists:pouzivatel,id',
            'veduci_pracoviska_id'=> 'required|exists:pouzivatel,id',
            'pracovnik_fpvai_id'=> 'required|exists:pouzivatel,id',
            'kontaktna_osoba_id'=> 'required|exists:pouzivatel,id',
            'predmety_id' => 'required|exists:predmety,id',
            'dokumenty_id'=> 'required|exists:dokumenty,id',
            'zmluva_id'=> 'required|exists:zmluva,id',
        ]);

        Internship::whereId($id)->update($validatedData);
        return redirect()->route('prax.index')->with('success', 'Prax bola úspešne aktualizovaná.');
    } catch (\Exception $e) {
        return redirect()->route('prax.index')->with('error', 'Chyba pri vytváraní praxe: ' . $e->getMessage());
    }
    }


    public function destroy($id)
    {
        Internship::destroy($id);

        return redirect()->route('prax.index')->with('success', 'Prax bola úspešne odstránená.');
    }

}
