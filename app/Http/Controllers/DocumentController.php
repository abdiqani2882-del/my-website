<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Document;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Document::where('user_id', Auth::id());
        
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $documents = $query->latest()->paginate(10)->withQueryString();
        return view('documents.index', compact('documents', 'search'));
    }

    public function create()
    {
        return view('documents.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'file' => ['required', 'file', 'max:10240'], // 10MB max
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('documents', 'public');
            $validatedData['file_path'] = $path;
        }

        $validatedData['user_id'] = Auth::id();
        Document::create($validatedData);

        return redirect()->route('documents.index')->with('success', 'Document uploaded successfully.');
    }

    public function edit(Document $document)
    {
        $this->authorizeOwner($document);
        return view('documents.edit', compact('document'));
    }

    public function update(Request $request, Document $document)
    {
        $this->authorizeOwner($document);

        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'file' => ['nullable', 'file', 'max:10240'],
        ]);

        if ($request->hasFile('file')) {
            if ($document->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }
            $path = $request->file('file')->store('documents', 'public');
            $validatedData['file_path'] = $path;
        }

        $document->update($validatedData);

        return redirect()->route('documents.index')->with('success', 'Document updated successfully.');
    }

    public function destroy(Document $document)
    {
        $this->authorizeOwner($document);

        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->route('documents.index')->with('success', 'Document deleted successfully.');
    }

    public function download(Document $document)
    {
        $this->authorizeOwner($document);

        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            $fileName = $document->title . '.' . pathinfo($document->file_path, PATHINFO_EXTENSION);
            return Storage::disk('public')->download($document->file_path, $fileName);
        }

        return back()->with('error', 'File not found on server.');
    }

    private function authorizeOwner(Document $document)
    {
        if ($document->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
