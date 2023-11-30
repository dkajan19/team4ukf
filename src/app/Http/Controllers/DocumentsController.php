<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentsController extends Controller
{
    public function index()
    {
        $documents = Documents::all();

        return view('documents.index', compact('documents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'typ_dokumentu' => 'required|string|max:255',
            'dokument' => 'required|mimes:pdf,doc,docx|max:2048',
    ]);

    $uploadedFile = $request->file('dokument');

    $documentPath = Storage::disk('public')->put('documents', $uploadedFile);

    Documents::create([
        'typ_dokumentu' => $request->input('typ_dokumentu'),
        'dokument' => $documentPath,
    ]);

    return redirect()->route('documents.index')
                    ->with('success', 'Document has been successfully created.');
    }

    public function show($id)
    {
        $documents = Documents::findOrFail($id);
    
        return view('documents.show', compact('documents'));
    }

    public function edit($id)
    {
        $documents = Documents::findOrFail($id);
    
        return view('documents.edit', compact('documents'));
    }

    public function update(Request $request, $id)   
    {
        $request->validate([
            'typ_dokumentu' => 'required|string|max:255',
            'dokument' => 'file|mimes:pdf,doc,docx|max:10240',
    ]);

    $documents = Documents::findOrFail($id);

    $documents->update([
        'typ_dokumentu' => $request->typ_dokumentu,
    ]);

    if ($request->hasFile('dokument')) {
        if ($documents->dokument) {
            Storage::disk('public')->delete('documents/' . basename($documents->dokument));
        }

        $documentPath = $request->file('dokument')->store('documents', 'public');
        $documents->update([
            'dokument' => $documentPath,
        ]);
    }

    return redirect()->route('documents.edit', $documents->id)
                    ->with('success', 'Document has been successfully updated.');
    }

    public function destroy($id)
    {
        $documents = Documents::findOrFail($id);

        Storage::disk('public')->delete('documents/' . basename($documents->dokument));

        $documents->delete();

        return redirect()->route('documents.index')
                        ->with('success', 'Document has been successfully removed.');
    }

    public function download($id)
    {
        $document = Documents::findOrFail($id);

        $filePath = storage_path("app/public/{$document->dokument}");

        $fileName = basename($filePath);

        return response()->download($filePath, $fileName);
    }
}