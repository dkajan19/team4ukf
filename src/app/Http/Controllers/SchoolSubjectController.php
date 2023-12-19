<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SchoolSubject;
use App\Models\StudyProgram;

class SchoolSubjectController extends Controller
{
    public function index()
    {
        $schoolSubjects = SchoolSubject::all();
        $studyPrograms = StudyProgram::all();

        $user = Auth::user();
        $role = $user->user_roles->rola;

        return view('school_subject.index', compact('schoolSubjects','role','studyPrograms'));
    }

    public function show($id)
    {
        $schoolSubject = SchoolSubject::with('study_programs')->findOrFail($id);

        return view('school_subject.show', compact('schoolSubject'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nazov' => 'required',
            'skratka' => 'required',
            'studijny_program_id' => 'required|exists:studijny_program,id',
        ]);

        $schoolSubject = SchoolSubject::create([
            'nazov' => $request->input('nazov'),
            'skratka' => $request->input('skratka'),
            'studijny_program_id' => $request->input('studijny_program_id'),
        ]);

        return redirect()->route('school_subject.index')->with('success', 'Predmet úspešne vytvorený!');
    }


    public function create()
    {
        $studyPrograms = StudyProgram::all();
        return view('school_subject.create', compact('studyPrograms'));
    }



    public function edit($id)
    {
        $schoolSubject = SchoolSubject::findOrFail($id);
        $studyPrograms = StudyProgram::all();

        return view('school_subject.edit', compact('schoolSubject', 'studyPrograms'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nazov' => 'required|string|max:255',
            'skratka' => 'required|string|max:20',
            'studijny_program_id' => 'required|exists:studijny_program,id',
        ]);

        $schoolSubject = SchoolSubject::findOrFail($id);
        $schoolSubject->update($validatedData);

        return redirect()->route('school_subject.edit', $schoolSubject->id)->with('success', 'Predmet úspešne aktualizovaný!');
    }


    public function destroy($id)
    {
        $schoolSubject = SchoolSubject::findOrFail($id);
        $schoolSubject->delete();

        return redirect()->route('school_subject.index')->with('success', 'Predmet úspešne vymazaný!');
    }


}
