<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\FeedBack;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyWorkerController extends Controller
{
    public function index()
    {   
        //$user = Auth::user();
        $companyworker = auth()->user();
        $role = $companyworker->user_roles->rola;
        $feedbacks = FeedBack::whereHas('internship', function ($query) use ($companyworker) {
            $query->where('kontaktna_osoba_id', $companyworker->id);
        })->get();
        $praxes = Internship::where('kontaktna_osoba_id', $companyworker->id)->get();
        $workers = User::whereHas('user_roles', function ($query) {
            $query->where('rola', 'Zástupca firmy alebo organizácie');
        })->get();


        return view('companyworker.feedback_index', compact('feedbacks', 'praxes', 'role'));
    }

    public function feedback_show($id)
    {   
        $feedback = FeedBack::findOrFail($id);
        $companyworker = auth()->user();
        $role = $companyworker->user_roles->rola;
        return view('companyworker.feedback_show', compact('feedback', 'role'));
    }

    public function feedback_edit($id)
    {   
        $feedback = FeedBack::with('internship')->find($id);
        $praxes = Internship::all();
        $companyworker = auth()->user();
        $role = $companyworker->user_roles->rola;

        return view('companyworker.feedback_edit', compact('feedback', 'praxes', 'role'));
    }

    public function feedback_store(Request $request)
    {   
        $validatedData = $request->validate([
            'feedback' => 'required',
            'prax_id' => 'required|exists:prax,id',
        ]);

        $existingFeedback = FeedBack::where('prax_id', $validatedData['prax_id'])->first();

    if ($existingFeedback) {
        return redirect()->route('companyworker.feedback_index')->with('error', 'Feedback pre túto prax už existuje.');
    }

        FeedBack::create($validatedData);

        return redirect()->route('companyworker.feedback_index')->with('success', 'Feedback úspešne pridaný.');
    }

    public function feedback_update(Request $request, $id)
    {   
        $validatedData = $request->validate([
            'feedback' => 'required',
        ]);

        $existingFeedback = Feedback::where('prax_id', $request->prax_id)->where('id', '!=', $id)->first();
    
        if ($existingFeedback) {
            return redirect()->route('companyworker.feedback_index')->with('error', 'Feedback pre túto prax už existuje.');
        }
    
        Feedback::whereId($id)->update($validatedData + ['prax_id' => $request->prax_id]);
    
        return redirect()->route('companyworker.feedback_index')->with('success', 'Feedback úspešne aktualizovaný.');
    }


    public function feedback_destroy($id)
    {   
        FeedBack::destroy($id);
        
        return redirect()->route('companyworker.feedback_index')->with('success', 'Feedback úspešne odstránený.');
    }


}