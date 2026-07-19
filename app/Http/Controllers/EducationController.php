<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Education;

class EducationController extends Controller
{
    /**
     * Display a listing of the education records.
     */
    public function index()
    {
        $education = Education::where('user_id', Auth::id())
            ->orderBy('start_date', 'desc')
            ->paginate(10);

        return view('education.index', compact('education'));
    }

    /**
     * Show the form for creating a new education record.
     */
    public function create()
    {
        return view('education.create');
    }

    /**
     * Store a newly created education record.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'school_name' => ['required', 'string', 'max:255'],
            'degree' => ['required', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'gpa' => ['nullable', 'string', 'max:10'],
            'status' => ['required', 'string', 'max:50'], // e.g. Completed, In Progress, Graduated
            'file' => ['nullable', 'file', 'mimes:pdf,jpeg,png,jpg,webp', 'max:4096'],
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('education_certs', 'public');
            $validatedData['certificate_path'] = $path;
        }

        $validatedData['user_id'] = Auth::id();
        Education::create($validatedData);

        return redirect()->route('education.index')->with('success', 'Education record added successfully.');
    }

    /**
     * Show the form for editing the specified education record.
     */
    public function edit(Education $education)
    {
        $this->authorizeOwner($education);
        return view('education.edit', compact('education'));
    }

    /**
     * Update the specified education record.
     */
    public function update(Request $request, Education $education)
    {
        $this->authorizeOwner($education);

        $validatedData = $request->validate([
            'school_name' => ['required', 'string', 'max:255'],
            'degree' => ['required', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'gpa' => ['nullable', 'string', 'max:10'],
            'status' => ['required', 'string', 'max:50'],
            'file' => ['nullable', 'file', 'mimes:pdf,jpeg,png,jpg,webp', 'max:4096'],
        ]);

        if ($request->hasFile('file')) {
            // Delete old file
            if ($education->certificate_path) {
                Storage::disk('public')->delete($education->certificate_path);
            }
            $path = $request->file('file')->store('education_certs', 'public');
            $validatedData['certificate_path'] = $path;
        }

        $education->update($validatedData);

        return redirect()->route('education.index')->with('success', 'Education record updated successfully.');
    }

    /**
     * Remove the specified education record.
     */
    public function destroy(Education $education)
    {
        $this->authorizeOwner($education);

        if ($education->certificate_path) {
            Storage::disk('public')->delete($education->certificate_path);
        }

        $education->delete();

        return redirect()->route('education.index')->with('success', 'Education record deleted successfully.');
    }

    /**
     * Download the associated certificate.
     */
    public function download(Education $education)
    {
        $this->authorizeOwner($education);

        if ($education->certificate_path && Storage::disk('public')->exists($education->certificate_path)) {
            return Storage::disk('public')->download($education->certificate_path, 'education_certificate.' . pathinfo($education->certificate_path, PATHINFO_EXTENSION));
        }

        return back()->with('error', 'Certificate file not found.');
    }

    /**
     * Enforce ownership.
     */
    private function authorizeOwner(Education $education)
    {
        if ($education->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
