<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{

    public function index()
    {
        $companies = Company::all();

        $user = Auth::user();
        $role = $user->user_roles->rola;

        return view('company.index', compact('companies', 'role'));
    }

    public function show($id)
    {
        $company = Company::findOrFail($id);
        return view('company.show', compact('company'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nazov_firmy' => 'required',
            'IČO' => 'required',
            'meno_kontaktnej_osoby' => 'required',
            'priezvisko_kontaktnej_osoby' => 'required',
            'email' => 'required',
            'tel_cislo' => 'required',
        ]);

        $company = Company::create([
            'nazov_firmy' => $request->input('nazov_firmy'),
            'IČO' => $request->input('IČO'),
            'meno_kontaktnej_osoby' => $request->input('meno_kontaktnej_osoby'),
            'priezvisko_kontaktnej_osoby' => $request->input('priezvisko_kontaktnej_osoby'),
            'email' => $request->input('email'),
            'tel_cislo' => $request->input('tel_cislo'),
        ]);

        return redirect()->route('company.index')->with('success', 'Company has been successfully created!');
    }

    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return view('company.edit', compact('company'));
    }

    public function update(Request $request, $id)
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

        return redirect()->route('company.edit', $company->id)
            ->with('success', 'Company has been successfully updated!');
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return redirect()->route('company.index')
            ->with('success', 'Company has been successfully deleted!');
    }
}
