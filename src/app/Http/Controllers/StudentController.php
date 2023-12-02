<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudyProgram;
use App\Models\SchoolSubject;
use App\Models\Internship;
use App\Models\Company;
use App\Models\User;
use App\Models\Documents;
use App\Models\Contract;

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
        $prax = $student->prax()->first();

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

            if ($student->prax->count() > 0) {
                $praxes = $student->prax()
                    ->with(['schoolSubject', 'contract', 'contract.company.addresses','head','worker','documents'])
                    ->get();

                $companies_all = Company::all();

                return view('student.internship_details', compact('praxes', 'student', 'companies_all','role'));
            } else {
                return redirect()->route('student.internship_details')->with('error', 'Nenašli sa žiadne podrobnosti o praxi.');
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
        ]);

        $randomWorker = User::whereHas('user_roles', function ($query) {
            $query->where('rola', 'Poverený pracovník pracoviska');
        })->inRandomOrder()->firstOrFail();

        $randomHeadWorker = User::whereHas('user_roles', function ($query) {
            $query->where('rola', 'Vedúci pracoviska');
        })->inRandomOrder()->firstOrFail();

        $kontaktnaOsoba = User::where('firma_id', $validatedData['company_id_add'])
            ->whereHas('user_roles', function ($query) {
                $query->where('rola', 'Zástupca firmy alebo organizácie');
            })
            ->firstOrFail();

        $document = Documents::create([
            'typ_dokumentu' => 'pdf',
            'dokument' => 'null',
        ]);

        $lastInternshipId = Internship::max('id');

        $contract = Contract::create([
            'zmluva' => (string)($validatedData['company_id_add'] . "_" . ($lastInternshipId + 1)),
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
            'datum_zaciatku' => now(),  //treba zmenit ze datum moze byt null
            'datum_konca' => now(), //treba zmenit ze datum moze byt null
        ]);

        return redirect()->route('student.internship_details')->with('success', 'Prax bola úspešne pridaná.');
    } 

}
