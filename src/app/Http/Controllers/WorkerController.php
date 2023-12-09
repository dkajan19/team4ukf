<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Company;
use App\Models\User;


use App\Models\Address;
class WorkerController extends Controller
{
    public function company_index()
    {
        $companies = Company::all();

        $user = Auth::user();
        $role = $user->user_roles->rola;

        return view('worker.company', compact('companies','role'));
    }

    public function company_show($id)
    {
        $company = Company::findOrFail($id);

        $user = Auth::user();
        $role = $user->user_roles->rola;

        return view('worker.company_show', compact('company','role'));
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
        return view('worker.company', compact('company'));
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
            ->with('success', 'Company has been successfully updated!');
    }

    public function company_destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return redirect()->route('worker.company')
            ->with('success', 'Company has been successfully deleted!');
    }





}
