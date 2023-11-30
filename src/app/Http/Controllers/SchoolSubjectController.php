<?php

namespace App\Http\Controllers;

use App\Models\SchoolSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchoolSubjectController extends Controller
{
    public function index()
    {
        $schoolSubjects = SchoolSubject::all();

        $user = Auth::user();
        $role = $user->user_roles->rola;

        return view('school_subject.index', compact('schoolSubjects'),compact('role'));
    }

    public function show($id)
    {
        $schoolSubject = SchoolSubject::findOrFail($id);
        return view('school_subject.show', compact('schoolSubject'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nazov' => 'required',
            'skratka' => 'required',
        ]);

        $schoolSubject = SchoolSubject::create([
            'nazov' => $request->input('nazov'),
            'skratka' => $request->input('skratka'),
        ]);

        return redirect()->route('school_subject.index')->with('success', 'School Subject created successfully.');
    }

    public function edit($id)
    {
        $schoolSubject = SchoolSubject::findOrFail($id);
        return view('school_subject.edit', compact('schoolSubject'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nazov' => 'required|string|max:255',
            'skratka' => 'required|string|max:10',
        ]);

        $schoolSubject = SchoolSubject::findOrFail($id);
        $schoolSubject->update($validatedData);

        return redirect()->route('school_subject.edit', $schoolSubject->id)
            ->with('success', 'School subject updated successfully!');
    }

    public function destroy($id)
    {
        $schoolSubject = SchoolSubject::findOrFail($id);
        $schoolSubject->delete();

        return redirect()->route('school_subject.index')
            ->with('success', 'School subject deleted successfully!');
    }






}
