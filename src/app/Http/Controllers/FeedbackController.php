<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\FeedBack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = FeedBack::with('internship')->get();
        $praxes = Internship::all();

        $user = Auth::user();
        $role = $user->user_roles->rola;

        return view('feedback.index', compact('feedbacks', 'praxes', 'role'));
    }

    public function edit($id)
    {
        $feedback = FeedBack::with('internship')->find($id);
        $praxes = Internship::all();

        return view('feedback.edit', compact('feedback', 'praxes'));
    }

    public function show($id)
    {
        $feedback = FeedBack::findOrFail($id);
        return view('feedback.show', compact('feedback'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'feedback' => 'required',
            'prax_id' => 'required|exists:prax,id',
        ]);
        
        $existingFeedback = FeedBack::where('prax_id', $validatedData['prax_id'])->first();

    if ($existingFeedback) {
        return redirect()->route('feedback.index')->with('error', 'Feedback pre túto prax už existuje.');
    }

        FeedBack::create($validatedData);

        return redirect()->route('feedback.index')->with('success', 'Feedback úspešne pridaný.');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'feedback' => 'required',
        ]);
    
        $existingFeedback = Feedback::where('prax_id', $request->prax_id)->where('id', '!=', $id)->first();
    
        if ($existingFeedback) {
            return redirect()->route('feedback.index')->with('error', 'Feedback pre túto prax už existuje.');
        }
    
        Feedback::whereId($id)->update($validatedData + ['prax_id' => $request->prax_id]);
    
        return redirect()->route('feedback.index')->with('success', 'Feedback úspešne aktualizovaný.');
    }


    public function destroy($id)
    {
        FeedBack::destroy($id);

        return redirect()->route('feedback.index')->with('success', 'Feedback úspešne odstránený.');
    }
}
