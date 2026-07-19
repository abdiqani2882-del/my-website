<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Certificate;

class CertificateController extends Controller
{
    /**
     * Display a listing of the certificates with search and filter features.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $user = Auth::user();

        $query = Certificate::where('user_id', $user->id);

        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('institution', 'like', "%{$search}%")
                  ->orWhere('certificate_number', 'like', "%{$search}%");
            });
        }

        $certificates = $query->latest()->paginate(6)->withQueryString();

        return view('certificates.index', compact('certificates', 'search'));
    }

    /**
     * Show the form for creating a new certificate.
     */
    public function create()
    {
        return view('certificates.create');
    }

    /**
     * Store a newly created certificate in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'institution' => ['required', 'string', 'max:255'],
            'certificate_number' => ['nullable', 'string', 'max:100'],
            'issue_date' => ['required', 'date'],
            'expiry_date' => ['nullable', 'date', 'after_or_equal:issue_date'],
            'description' => ['nullable', 'string'],
            'file' => ['required', 'file', 'mimes:pdf,jpeg,png,jpg,webp', 'max:4096'],
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('certificates', 'public');
            $validatedData['file_path'] = $path;
        }

        $validatedData['user_id'] = Auth::id();
        Certificate::create($validatedData);

        return redirect()->route('certificates.index')->with('success', 'Certificate added successfully.');
    }

    /**
     * Display the specified certificate details.
     */
    public function show(Certificate $certificate)
    {
        $this->authorizeOwner($certificate);
        return view('certificates.show', compact('certificate'));
    }

    /**
     * Show the form for editing the specified certificate.
     */
    public function edit(Certificate $certificate)
    {
        $this->authorizeOwner($certificate);
        return view('certificates.edit', compact('certificate'));
    }

    /**
     * Update the specified certificate in storage.
     */
    public function update(Request $request, Certificate $certificate)
    {
        $this->authorizeOwner($certificate);

        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'institution' => ['required', 'string', 'max:255'],
            'certificate_number' => ['nullable', 'string', 'max:100'],
            'issue_date' => ['required', 'date'],
            'expiry_date' => ['nullable', 'date', 'after_or_equal:issue_date'],
            'description' => ['nullable', 'string'],
            'file' => ['nullable', 'file', 'mimes:pdf,jpeg,png,jpg,webp', 'max:4096'],
        ]);

        if ($request->hasFile('file')) {
            // Delete old file
            if ($certificate->file_path) {
                Storage::disk('public')->delete($certificate->file_path);
            }
            $path = $request->file('file')->store('certificates', 'public');
            $validatedData['file_path'] = $path;
        }

        $certificate->update($validatedData);

        return redirect()->route('certificates.index')->with('success', 'Certificate updated successfully.');
    }

    /**
     * Remove the specified certificate from storage.
     */
    public function destroy(Certificate $certificate)
    {
        $this->authorizeOwner($certificate);

        if ($certificate->file_path) {
            Storage::disk('public')->delete($certificate->file_path);
        }

        $certificate->delete();

        return redirect()->route('certificates.index')->with('success', 'Certificate deleted successfully.');
    }

    /**
     * Download the certificate file.
     */
    public function download(Certificate $certificate)
    {
        $this->authorizeOwner($certificate);
        
        if ($certificate->file_path && Storage::disk('public')->exists($certificate->file_path)) {
            return Storage::disk('public')->download($certificate->file_path, $certificate->title . '.' . pathinfo($certificate->file_path, PATHINFO_EXTENSION));
        }

        return back()->with('error', 'File not found on server.');
    }

    /**
     * Inline preview of the certificate file.
     */
    public function preview(Certificate $certificate)
    {
        $this->authorizeOwner($certificate);

        if ($certificate->file_path && Storage::disk('public')->exists($certificate->file_path)) {
            return Storage::disk('public')->response($certificate->file_path);
        }

        return abort(404, 'File not found.');
    }

    /**
     * Enforce ownership security check.
     */
    private function authorizeOwner(Certificate $certificate)
    {
        if ($certificate->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
