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
    $user = Auth::user();
    $praxe = Internship::all();
    if ($user) {
        $praxInternships = $user->prax;
        $praxeInternships = $user->praxe;
        $praxeaInternships = $user->praxea;
        $praxebInternships = $user->praxeb;
        $documents = Documents::with('internships')->get();
        $schoolSubjects = SchoolSubject::with('praxess')->get();
        $contracts = Contract::with('praxee')->get();

        $role = $user->user_roles->rola;

        return view('prax.index', compact('praxe','praxInternships', 'praxeInternships', 'praxeaInternships', 'praxebInternships', 'documents', 'schoolSubjects', 'contracts', 'role'));
    } else {
    }
}


    public function edit($id)
    {   
        $prax = Internship::all();
        $userr = User::findOrFail($id);
        $praxInternship = $user->prax;
        $praxeInternship = $user->praxe;
        $praxeaInternship = $user->praxea;
        $praxebInternship = $user->praxeb;
        $document = Documents::with('internships')->findOrFail($id);
        $schoolSubject = SchoolSubject::with('praxess')->findOrFail($id);
        $contract = Contract::with('praxee')->findOrFail($id);

        return view('prax.index', compact('prax','praxInternship','praxeInternship','praxeaInternship','praxebInternship','document','schoolSubject','contract'));
    }

    public function show($id)
    {
        $prax = Internship::findOrFail($id);
        return view('prax.show', compact('prax'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
        'popis_praxe' => 'required|string|max:255',
        'datum_zaciatku'=> 'required|date|date_format:Y-m-d',
        'datum_konca'=> 'required|date|date_format:Y-m-d',
        'aktualny_stav'=> 'sometimes|string|max:255',
        'predmety_id' => 'required|exists:predmety,id',
        'student_id' => 'required|exists:student,id',
        'veduci_pracoviska_id'=> 'required|exists:veduci_pracoviska,id',
        'pracovnik_fpvai_id'=> 'required|exists:pracovnik_fpvai,id',
        'kontaktna_osoba_id'=> 'required|exists:kontaktna_osoba,id',
        'dokumenty_id'=> 'required|exists:dokumenty,id',
        'zmluva_id'=> 'required|exists:zmluva,id',
        ]);

        Internship::create($validatedData);

        return redirect()->route('prax.index')->with('success', 'Prax bola úspešne pridaná.');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
        'popis_praxe' => 'required|string|max:255',
        'datum_zaciatku'=> 'required|date|date_format:Y-m-d',
        'datum_konca'=> 'required|date|date_format:Y-m-d',
        'aktualny_stav'=> 'sometimes|string|max:255',
        'predmety_id' => 'required|exists:predmety,id',
        'student_id' => 'required|exists:student,id',
        'veduci_pracoviska_id'=> 'required|exists:veduci_pracoviska,id',
        'pracovnik_fpvai_id'=> 'required|exists:pracovnik_fpvai,id',
        'kontaktna_osoba_id'=> 'required|exists:kontaktna_osoba,id',
        'dokumenty_id'=> 'required|exists:dokumenty,id',
        'zmluva_id'=> 'required|exists:zmluva,id',
        ]);

        Internship::whereId($id)->update($validatedData);

        return redirect()->route('prax.index')->with('success', 'Prax bola úspešne aktualizovaná');
    }


    public function destroy($id)
    {
        Internship::destroy($id);

        return redirect()->route('prax.index')->with('success', 'Prax bola úspešne odstránená.');
    }

}
