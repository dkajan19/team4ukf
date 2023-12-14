<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\StudyProgram;
use App\Models\SchoolSubject;
use App\Models\Internship;
use App\Models\Company;
use App\Models\User;
use App\Models\Documents;
use App\Models\Contract;
use App\Models\Address;


class StudentController extends Controller
{
    public function index()
    {
        $studijneProgramy = StudyProgram::all();
        $selectedProgram = null;
        $student = auth()->user();
        $role = $student->user_roles->rola;
        $prax = $student->prax()->first();

        return view('student.program_and_subject', compact('studijneProgramy', 'selectedProgram', 'student','prax','role'));
    }

    public function selectProgram(Request $request)
    {
        $selectedProgram = StudyProgram::find($request->studijny_program);
        $studijneProgramy = StudyProgram::all();
        $student = auth()->user();
        $role = $student->user_roles->rola;
        $prax = $student->prax()->latest()->first();

        return view('student.program_and_subject', compact('studijneProgramy', 'selectedProgram', 'student','prax','role'));
    }

    public function assignSubject(Request $request)
    {
        $validatedData = $request->validate([
            'selected_subject' => 'required|exists:predmety,id',
        ]);

        $selectedSubject = SchoolSubject::find($validatedData['selected_subject']);
        $student = auth()->user();

        if ($selectedSubject) {
            $prax = $student->prax()->where('aktualny_stav', 'vytvorena')->first();

            if ($prax) {
                $updateResult = $prax->update([
                    'predmety_id' => $selectedSubject->id,
                ]);

                if ($updateResult) {
                    return redirect()->route('student.program_and_subject')->with('success', 'Predmet bol úspešne aktualizovaný.');
                } else {
                    return redirect()->route('student.program_and_subject')->with('error', 'Nastala chyba pri aktualizácii predmetu.');
                }
            } else {
                return redirect()->route('student.program_and_subject')->with('error', 'Študent nemá existujúci záznam praxe s aktuálnym stavom "vytvorená".');
            }
        } else {
            return redirect()->route('student.program_and_subject')->with('error', 'Nastala chyba pri priradení predmetu.');
        }
    }


    public function internshipDetails()
    {
        if (auth()->check()) {
            $student = auth()->user();
            $role = $student->user_roles->rola;
            $companies_all = Company::all();

            if ($student->prax->count() > 0) {
                $praxes = $student->prax()
                    ->with(['schoolSubject', 'contract', 'contract.company.addresses','head','worker','documents'])
                    ->get();

                return view('student.internship_details', compact('praxes', 'student', 'companies_all','role'));
            } else {
                //return redirect()->route('student.internship_details')->with('error', 'Nenašli sa žiadne praxe.');
                //return response('Neexistuje žiadna priradená prax', 404)->header('Content-Type', 'text/plain');
                return view('student.internship_details', compact('student', 'role', 'companies_all'));                
            }
        } else {
            return redirect()->route('login')->with('error', 'Ak si chcete pozrieť podrobnosti o praxi, prihláste sa.');
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
            $kontaktnaOsoba = User::where('firma_id', $validatedData['company_id_add'])
                ->whereHas('user_roles', function ($query) {
                    $query->where('rola', 'Zástupca firmy alebo organizácie');
                })
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withErrors(['kontaktnaOsoba' => 'Zástupca firmy neexistuje alebo nie je správne priradený.']);
        }

        $document = Documents::create([
            'typ_dokumentu' => (string)($validatedData['company_id_add'] . "_" . (($lastInternshipId ?? 0) + 1)),
            'dokument' => 'null',
        ]);

        $lastInternshipId = Internship::max('id');

        $contract = Contract::create([
            'zmluva' => (string)($validatedData['company_id_add'] . "_" . (($lastInternshipId ?? 0) + 1)),
            'firma_id' => $validatedData['company_id_add'],
        ]);

        $internship = Internship::create([
            'popis_praxe' => $validatedData['description_add'],
            'firma_id' => $validatedData['company_id_add'],
            'student_id' => auth()->user()->id,
            'pracovnik_fpvai_id' => $randomWorker->id,
            'veduci_pracoviska_id' => $randomHeadWorker->id,
            'kontaktna_osoba_id' => $kontaktnaOsoba->id,
            'dokumenty_id' => $document->id,
            'zmluva_id' => $contract->id,
            'datum_zaciatku' => $validatedData['datum_zaciatku_add'],
            'datum_konca' => $validatedData['datum_konca_add'],
        ]);

        return redirect()->route('student.internship_details')->with('success', 'Prax bola úspešne pridaná.');
    } 

    public function report()
    {
        $student = auth()->user();
        $role = $student->user_roles->rola;
        $prax = $student->prax()->latest()->first();

        if ($prax) {
            return view('student.report', compact('student', 'prax', 'role'));
        } else {
            //return response('Neexistuje žiadna priradená prax', 404)->header('Content-Type', 'text/plain');
            return view('student.report', compact('student', 'prax', 'role','prax'));
        }
    }

    public function company_index()
    {
        $companies = Company::all();

        $user = Auth::user();
        $role = $user->user_roles->rola;

        return view('student.company', compact('companies','role'));
    }

    public function company_show($id)
    {
        $company = Company::findOrFail($id);

        $user = Auth::user();
        $role = $user->user_roles->rola;

        return view('student.company_show', compact('company','role'));
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

        return redirect()->route('student.company')->with('success', 'Firma bola úspešne pridaná!');
    }

    public function documents()
    {
        $student = auth()->user();
        $role = $student->user_roles->rola;
        $prax = $student->prax()->latest()->first();

        return view('student.documents', compact('student','prax','role'));
    }

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

    public function documents_download($id)
    {
        $document = Documents::findOrFail($id);

        $filePath = storage_path("app/public/{$document->dokument}");

        $fileName = basename($filePath);

        return response()->download($filePath, $fileName);
    }

    public function documents_destroy($id)
    {
        $documents = Documents::findOrFail($id);

        $documents->update([
            'dokument' => "null",
        ]);

        Storage::disk('public')->delete('documents/' . basename($documents->dokument));

        return redirect()->route('student.documents')->with('success', 'Dokumenty boli úspešne odstránené.');
    }

}
