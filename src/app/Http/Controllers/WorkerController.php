<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Company;
use App\Models\User;
use App\Models\Internship;
use App\Models\Contract;
use App\Models\UserRole;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\Address;
class WorkerController extends Controller
{
    public function company_index()
    {
        $companies = Company::all();

        $user = Auth::user();
        $role = $user->user_roles->rola;
        $prax = $user->prax()->latest()->first();

        return view('worker.company', compact('companies', 'role'));
    }

    public function company_show($id)
    {
        $company = Company::findOrFail($id);

        $user = Auth::user();
        $role = $user->user_roles->rola;

        return view('worker.company_show', compact('company', 'role'));
    }

    public function company_store(Request $request)
    {
        $request->validate([
            'nazov_firmy' => 'required',
            'IČO' => 'required',
            'meno_kontaktnej_osoby' => 'required',
            'priezvisko_kontaktnej_osoby' => 'required',
            'email' => 'required',
            'tel_cislo' => 'required',
            'mesto' => 'required',
            'PSČ' => 'required',
            'ulica' => 'required',
            'č_domu' => 'required',
        ]);

        $new_company = Company::create([
            'nazov_firmy' => $request->input('nazov_firmy'),
            'IČO' => $request->input('IČO'),
            'meno_kontaktnej_osoby' => $request->input('meno_kontaktnej_osoby'),
            'priezvisko_kontaktnej_osoby' => $request->input('priezvisko_kontaktnej_osoby'),
            'email' => $request->input('email'),
            'tel_cislo' => $request->input('tel_cislo'),
        ]);

        $address = Address::create([
            'mesto' => $request->input('mesto'),
            'PSČ' => $request->input('PSČ'),
            'ulica' => $request->input('ulica'),
            'č_domu' => $request->input('č_domu'),
            'firma_id' => $new_company->id,
        ]);

        return redirect()->route('worker.company')->with('success', 'Firma bola úspešne pridaná!');
    }

    public function company_edit($id)
    {
        $company = Company::findOrFail($id);

        $user = Auth::user();
        $role = $user->user_roles->rola;

        return view('worker.company_edit', compact('company', 'role'));
    }

    public function company_update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nazov_firmy' => 'required|string|max:255',
            'IČO' => 'required|integer',
            'meno_kontaktnej_osoby' => 'required|string|max:255',
            'priezvisko_kontaktnej_osoby' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'tel_cislo' => 'required|string|max:15',
        ]);

        $company = Company::findOrFail($id);
        $company->update($validatedData);

        return redirect()->route('worker.company', $company->id)
            ->with('success', 'Firma bola úspešne aktualizovaná!');
    }

    public function company_destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return redirect()->route('worker.company')
            ->with('success', 'Firma bola úspešne vymazaná!');
    }

    public function student_store(Request $request)
    {
        $request->validate([
            'meno' => 'required|string|max:255',
            'priezvisko' => 'required|string|max:255',
            'tel_cislo' => 'required|string|max:20',
            'email' => 'required|string|max:255',
            'password' => 'required|string|max:255',

        ]);

        $new_student = User::create([
            'meno' => $request->input('meno'),
            'priezvisko' => $request->input('priezvisko'),
            'tel_cislo' => $request->input('tel_cislo'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'rola_pouzivatela_id' => 1,
        ]);
        return redirect()->route('worker.student')->with('success', 'Študent bol úspešne pridaný!');
    }


    public function internshipDetails()
    {
        if (auth()->check()) {
            $user = Auth::user();
            $role = $user->user_roles->rola;
            $companies_all = Company::all();
            //$praxes = $user->prax()->all();
            $userId = Auth::id();
            $praxes = Internship::where('pracovnik_fpvai_id', $userId)->with(['schoolSubject', 'contract', 'contract.company.addresses','head','worker','documents'])->get();

            return view('worker.internship_details', compact('user', 'praxes', 'companies_all', 'role'));
        }
    }


    public function addCustomInternship(Request $request)
    {
        $validatedData = $request->validate([
            'company_id_add' => 'required|exists:firma,id',
            'description_add' => 'required|string',
            'datum_zaciatku_add' => 'required|date',
            'datum_konca_add' => 'required|date|after:datum_zaciatku_add',
        ]);

        $randomWorker = User::whereHas('user_roles', function ($query) {
            $query->where('rola', 'Poverený pracovník pracoviska');
        })->inRandomOrder()->firstOrFail();

        $randomHeadWorker = User::whereHas('user_roles', function ($query) {
            $query->where('rola', 'Vedúci pracoviska');
        })->inRandomOrder()->firstOrFail();

        try {
            $kontaktnaOsoba = User::where('firma_id', $validatedData['company_id_add'])->whereHas('user_roles', function ($query) {
                $query->where('rola', 'Zástupca firmy alebo organizácie');
            })->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withErrors(['kontaktnaOsoba' => 'Zástupca firmy neexistuje alebo nie je správne priradený.']);
        }


        $document = Documents::create([
            'typ_dokumentu' => (string)($validatedData['company_id_add'] . "_" . (($lastInternshipId ?? 0) + 1)),
        ]);

        $lastInternshipId = Internship::max('id');

        $contract = Contract::create([
            'zmluva' => (string)($validatedData['company_id_add'] . "_" . (($lastInternshipId ?? 0) + 1)),
            'firma_id' => $validatedData['company_id_add'],
        ]);

        $internship = Internship::create([
            'popis_praxe' => $validatedData['description_add'],
            'firma_id' => $validatedData['company_id_add'],
            'student_id' => 8,
            'pracovnik_fpvai_id' => $randomWorker->id,
            'veduci_pracoviska_id' => $randomHeadWorker->id,
            'kontaktna_osoba_id' => $kontaktnaOsoba->id,
            'predmety_id' => 10,
            'dokumenty_id' => $document->id,
            'zmluva_id' => $contract->id,
            'datum_zaciatku' => $validatedData['datum_zaciatku_add'],
            'datum_konca' => $validatedData['datum_konca_add'],
        ]);

        return redirect()->route('worker.internship_details')->with('success', 'Prax bola úspešne pridaná.');
    }


}
