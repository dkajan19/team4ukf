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
        $prax = Internship::all();
        $user = User::findOrFail($id);
        $praxInternship = $user->prax;
        $praxeInternship = $user->praxe;
        $praxeaInternship = $user->praxea;
        $praxebInternship = $user->praxeb;
        $document = Documents::with('internships')->findOrFail($id);
        $schoolSubject = SchoolSubject::with('praxess')->findOrFail($id);
        $contract = Contract::with('praxee')->findOrFail($id);

        return view('prax.edit', compact('prax', 'praxInternship', 'praxeInternship', 'praxeaInternship', 'praxebInternship', 'document', 'schoolSubject', 'contract'));
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
        'datum_zaciatku' => 'required|date|date_format:d-m-Y',
        'datum_konca'=> 'required|date|date_format:d-m-Y',
        'aktualny_stav'=> 'sometimes|string|max:255',
        'student_id' => 'required|exists:student,id',
        'veduci_pracoviska_id'=> 'required|exists:veduci_pracoviska,id',
        'pracovnik_fpvai_id'=> 'required|exists:pracovnik_fpvai,id',
        'kontaktna_osoba_id'=> 'required|exists:kontaktna_osoba,id',
        'predmety_id' => 'required|exists:predmety,id',
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
        'datum_zaciatku' => 'required|date|date_format:d-m-Y',
        'datum_konca'=> 'required|date|date_format:d-m-Y',
        'aktualny_stav'=> 'sometimes|string|max:255',
        'student_id' => 'required|exists:student,id',
        'veduci_pracoviska_id'=> 'required|exists:veduci_pracoviska,id',
        'pracovnik_fpvai_id'=> 'required|exists:pracovnik_fpvai,id',
        'kontaktna_osoba_id'=> 'required|exists:kontaktna_osoba,id',
        'predmety_id' => 'required|exists:predmety,id',
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
