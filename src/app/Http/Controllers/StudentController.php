<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudyProgram;
use App\Models\SchoolSubject;
use App\Models\Internship;

class StudentController extends Controller
{
    public function index()
    {
        $studijneProgramy = StudyProgram::all();
        $selectedProgram = null;
        $student = auth()->user();
        $prax = $student->prax()->first();

        return view('student.program_and_subject', compact('studijneProgramy', 'selectedProgram', 'student','prax'));
    }

    public function selectProgram(Request $request)
    {
        $selectedProgram = StudyProgram::find($request->studijny_program);
        $studijneProgramy = StudyProgram::all();
        $student = auth()->user();
        $prax = $student->prax()->first();

        return view('student.program_and_subject', compact('studijneProgramy', 'selectedProgram', 'student','prax'));
    }

    public function assignSubject(Request $request)
    {
        $validatedData = $request->validate([
            'selected_subject' => 'required|exists:predmety,id',
        ]);

        $selectedSubject = SchoolSubject::find($validatedData['selected_subject']);
        $student = auth()->user();

        if ($selectedSubject) {
            $prax = $student->prax()->first();

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
                return redirect()->route('student.program_and_subject')->with('error', 'Študent nemá existujúci záznam praxe.');
            }
        } else {
            return redirect()->route('student.program_and_subject')->with('error', 'Nastala chyba pri priradení predmetu.');
        }
    }

}
