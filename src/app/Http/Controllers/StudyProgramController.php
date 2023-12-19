<?php

namespace App\Http\Controllers;

use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudyProgramController extends Controller
{

    public function index()
    {
        $studyPrograms = StudyProgram::all();

        $user = Auth::user();
        $role = $user->user_roles->rola;

        return view('study_program.index', compact('studyPrograms'),compact('role'));
    }

    public function show($id)
    {
        $studyProgram = StudyProgram::findOrFail($id);
        return view('study_program.show', compact('studyProgram'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nazov' => 'required',
            'skratka' => 'required',
        ]);

        $studyProgram = StudyProgram::create([
            'nazov' => $request->input('nazov'),
            'skratka' => $request->input('skratka'),
        ]);

        return redirect()->route('study_program.index')->with('success', 'Study Program created successfully.');
    }

    public function edit($id)
    {
        $studyProgram = StudyProgram::findOrFail($id);
        return view('study_program.edit', compact('studyProgram'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nazov' => 'required|string|max:255',
            'skratka' => 'required|string|max:10',
        ]);

        $studyProgram = StudyProgram::findOrFail($id);
        $studyProgram->update($validatedData);

        return redirect()->route('study_program.edit', $studyProgram->id)
            ->with('success', 'Study program updated successfully!');
    }

    public function destroy($id)
    {
        $studyProgram = StudyProgram::findOrFail($id);
        $studyProgram->delete();

        return redirect()->route('study_program.index')
            ->with('success', 'Study program deleted successfully!');
    }
}
