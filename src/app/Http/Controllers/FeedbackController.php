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
        $feedbacks = FeedBack::all();
        $praxes = Internship::with('feedback')->get();

        $user = Auth::user();
        $role = $user->user_roles->rola;

        return view('feedback.index', compact('feedbacks', 'praxes', 'role'));
    }
    public function edit($id)
    {
        $feedback = FeedBack::all();
        $praxes = Internship::with('feedback')->get();


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

        FeedBack::create($validatedData);

        return redirect()->route('feedback.index')->with('success', 'Feedback úspešne pridaný.');
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'feedback' => 'required',
            'prax_id' => 'required|exists:prax,id',
        ]);

        FeedBack::whereId($id)->update($validatedData);

        return redirect()->route('feedback.index')->with('success', 'Feedback úspešne aktualizovaný.');
    }
    public function destroy($id)
    {
        FeedBack::destroy($id);

        return redirect()->route('feedback.index')->with('success', 'Feedback úspešne odstránený.');
    }
    

}