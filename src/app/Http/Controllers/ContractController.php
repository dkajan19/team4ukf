<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::with('company')->get();
        $companies = Company::all();

        $user = Auth::user();
        $role = $user->user_roles->rola;

        return view('contract.index', compact('contracts', 'companies', 'role'));
    }

    public function edit($id)
    {
        $contract = Contract::with('company')->find($id);
        $companies = Company::all();

        return view('contract.edit', compact('contract', 'companies'));
    }

    public function show($id)
    {
        $contract = Contract::findOrFail($id);
        return view('contract.show', compact('contract'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'zmluva' => 'required',
            'firma_id' => 'required|exists:firma,id',
        ]);

        Contract::create($validatedData);

        return redirect()->route('contract.index')->with('success', 'Zmluva úspešne pridaná.');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'zmluva' => 'required',
            'firma_id' => 'required|exists:firma,id',
        ]);

        Contract::whereId($id)->update($validatedData);

        return redirect()->route('contract.index')->with('success', 'Zmluva úspešne aktualizovaná');
    }

    public function destroy($id)
    {
        Contract::destroy($id);

        return redirect()->route('contract.index')->with('success', 'Zmluva úspešne odstránená.');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'firma_id');
    }
}
