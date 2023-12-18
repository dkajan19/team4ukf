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

        $new_user = User::create([
            'meno' => $request->input('meno_kontaktnej_osoby'),
            'priezvisko' => $request->input('priezvisko_kontaktnej_osoby'),
            'email' => $request->input('email'),
            'tel_cislo' => $request->input('tel_cislo'),
            'firma_id' => $new_company->id,
            'rola_pouzivatela_id' => 5,
            'password' => "password",
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




    public function internshipDetails()
    {
        if (auth()->check()) {
            $user = Auth::user();
            $role = $user->user_roles->rola;
            $companies_all = Company::all();
            //$praxes = $user->prax()->all();
            $userId = Auth::id();
            $praxes = Internship::where('pracovnik_fpvai_id', $userId)->with(['schoolSubject', 'contract', 'contract.company.addresses','head','worker','documents'])->get();

            $users = User::whereHas('user_roles', function ($query) {
                $query->where('rola', 'Študent');
            })->get();

            return view('worker.internship_details', compact('user', 'praxes', 'companies_all', 'role','users'));
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

    public function updateInternshipStatus(Request $request)
    {
        $internshipId = $request->input('internship_id');
        $newStatus = $request->input('new_status');

        $internship = Internship::findOrFail($internshipId);
        $internship->aktualny_stav = $newStatus;
        $internship->save();

        return response()->json(['message' => 'Stav praxe bol úspešne aktualizovaný.']);
    }

    public function updateInternshipStudent2(Request $request)
    {
        $internshipId = $request->input('internship_id');
        $studentId = $request->input('student_id');

        $internship = Internship::findOrFail($internshipId);
        $internship->student_id = $studentId;
        $internship->save();

        return response()->json(['message' => 'Student byl úspěšně přiřazen k praxi.']);
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
            'rola_pouzivatela_id' => 2,
        ]);
        return redirect()->route('worker.student')->with('success', 'Študent bol úspešne pridaný!');
    }

    public function student_index()
    {
        $rola_pouzivatela_id = 2;
        $users = User::where('rola_pouzivatela_id', $rola_pouzivatela_id)->get();

        $user = Auth::user();
        $role = $user->user_roles->rola;
        //$prax = $user->prax()->latest()->first();

        return view('worker.student', compact('users', 'role'));
    }

    public function student_show($id)
    {
        $user = Auth::user();
        $role = $user->user_roles->rola;

        $user = User::findOrFail($id);
        $prax = Internship::where('student_id', $id)->latest()->first();

        return view('worker.student_show', compact('user','prax', 'role'));
    }

    public function student_destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('worker.student')->with('success', 'Používateľ bol úspešne odstránený.');
    }
    public function documents_index()
    {
        $documentss = Documents::all();

        $user = Auth::user();
        $role = $user->user_roles->rola;
        //$prax = $user->prax()->latest()->first();

        return view('worker.documents', compact('documentss', 'role'));
    }

    /*
    public function documents_update(Request $request)
    {
        $request->validate([
            'dokument' => 'file|mimes:pdf,doc,docx|max:10240',
        ]);

        $student = auth()->user();
        $documents = $student->prax()->latest()->first()->documents;

        if ($request->hasFile('dokument')) {
            if ($documents->dokument) {
                Storage::disk('public')->delete('documents/' . basename($documents->dokument));
            }

            $documentPath = $request->file('dokument')->store('documents', 'public');
            $documents->update([
                'dokument' => $documentPath,
            ]);
        }

        return redirect()->route('student.documents', $documents->id)->with('success', 'Dokumenty boli úspešne aktualizované.');
    }
*/
    public function documents_destroy($id)
    {
        $documents = Documents::findOrFail($id);

        Storage::disk('public')->delete('documents/' . basename($documents->dokument));

        $documents->delete();

        return redirect()->route('worker.documents')->with('success', 'Dokumenty boli úspešne odstránené.');
    }

    public function report()
    {
        $worker = auth()->user();
        $role = $worker->user_roles->rola;
        $praxe = Internship::all();

        return view('worker.report', compact('praxe','role'));
    }
}
