<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Internship;
use App\Models\User;
use App\Models\Company;

class HeadWorkerController extends Controller
{
    public function index()
    {
        $headworker = auth()->user();
        $role = $headworker->user_roles->rola;
        $praxe = Internship::all();
        $workers = User::whereHas('user_roles', function ($query) {
            $query->where('rola', 'Poverený pracovník pracoviska');
        })->get();

        return view('headworker.internship_details', compact('praxe','workers','role'));
    }

    public function update_status(Request $request)
    {
        $praxeIds = $request->input('prax_id');
        $newState = $request->input('stav');

        Internship::where('id', $praxeIds)->update(['aktualny_stav' => $newState]);

        return redirect()->route('headworker.internship_details')->with('success', 'Stav praxe bol úspešne aktualizovaný!');
    }

    public function update_worker(Request $request)
    {
        $praxeIds = $request->input('prax_id');
        $newWorker = $request->input('worker_id');

        Internship::where('id', $praxeIds)->update(['pracovnik_fpvai_id' => $newWorker]);

        return redirect()->route('headworker.internship_details')->with('success', 'Poverený pracovník praxe bol úspešne aktualizovaný!');
    }

    public function show($id)
    {
        $internship = Internship::findOrFail($id);
        return view('headworker.internship_show', compact('internship'));
    }

    public function company_index()
    {
        $companies = Company::all();

        $user = Auth::user();
        $role = $user->user_roles->rola;

        return view('headworker.company', compact('companies','role'));
    }

    public function company_show($id)
    {
        $company = Company::findOrFail($id);

        $user = Auth::user();
        $role = $user->user_roles->rola;

        return view('headworker.company_show', compact('company','role'));
    }

    public function report()
    {
        $headworker = auth()->user();
        $role = $headworker->user_roles->rola;
        $praxe = Internship::all();
        
        return view('headworker.report', compact('praxe','role'));
    }

    public function feedback()
    {
        $headworker = auth()->user();
        $role = $headworker->user_roles->rola;
        $praxe = Internship::with('feedback')->get();

        return view('headworker.feedback', compact('praxe','role'));
    }

}