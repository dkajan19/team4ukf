<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Company;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::with('company')->get();
        $companies = Company::all();
        
        return view('address.index', compact('addresses','companies'));
    }

    public function edit($id)
    {
        $address = Address::with('company')->find($id);
        $companies = Company::all();

        return view('address.edit', compact('address', 'companies'));
    }

    public function show($id)
    {
        $address = Address::findOrFail($id);
        return view('address.show', compact('address'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'mesto' => 'required|string|max:255',
            'PSČ' => 'required|integer|digits:5',
            'ulica' => 'required|string|max:255',
            'č_domu' => 'required|string|max:255',
            'firma_id' => 'required|exists:firma,id',
        ]);

        Address::create($validatedData);


        return redirect()->route('address.index')->with('success', 'Adresa bola úspešne pridaná.');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'mesto' => 'required|string|max:255',
            'PSČ' => 'required|integer|digits:5',
            'ulica' => 'required|string|max:255',
            'č_domu' => 'required|string|max:255',
            'firma_id' => 'required|exists:firma,id',
        ]);

        Address::whereId($id)->update($validatedData);

        return redirect()->route('address.index')->with('success', 'Adresa bola úspešne aktualizovaná');
    }

    public function destroy($id)
    {
        $address = Address::findOrFail($id);
        $address->delete();

        return redirect()->route('address.index')
                        ->with('success', 'Adresa bola úspešne odstránená.');
    }
}
