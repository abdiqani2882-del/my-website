<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\WorkExperience;

class WorkExperienceController extends Controller
{
    public function index()
    {
        $workExperiences = WorkExperience::where('user_id', Auth::id())
            ->orderBy('start_date', 'desc')
            ->paginate(10);
        return view('work-experiences.index', compact('workExperiences'));
    }

    public function create()
    {
        return view('work-experiences.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'company' => ['required', 'string', 'max:255'],
            'job_title' => ['required', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_current' => ['boolean'],
            'job_description' => ['nullable', 'string'],
            'company_logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        if ($request->hasFile('company_logo')) {
            $validatedData['company_logo'] = $request->file('company_logo')->store('company_logos', 'public');
        }

        $validatedData['is_current'] = $request->has('is_current');
        if ($validatedData['is_current']) {
            $validatedData['end_date'] = null;
        }

        $validatedData['user_id'] = Auth::id();
        WorkExperience::create($validatedData);

        return redirect()->route('work-experiences.index')->with('success', 'Work experience added successfully.');
    }

    public function edit(WorkExperience $workExperience)
    {
        $this->authorizeOwner($workExperience);
        return view('work-experiences.edit', compact('workExperience'));
    }

    public function update(Request $request, WorkExperience $workExperience)
    {
        $this->authorizeOwner($workExperience);

        $validatedData = $request->validate([
            'company' => ['required', 'string', 'max:255'],
            'job_title' => ['required', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_current' => ['boolean'],
            'job_description' => ['nullable', 'string'],
            'company_logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        if ($request->hasFile('company_logo')) {
            if ($workExperience->company_logo) {
                Storage::disk('public')->delete($workExperience->company_logo);
            }
            $validatedData['company_logo'] = $request->file('company_logo')->store('company_logos', 'public');
        }

        $validatedData['is_current'] = $request->has('is_current');
        if ($validatedData['is_current']) {
            $validatedData['end_date'] = null;
        }

        $workExperience->update($validatedData);

        return redirect()->route('work-experiences.index')->with('success', 'Work experience updated successfully.');
    }

    public function destroy(WorkExperience $workExperience)
    {
        $this->authorizeOwner($workExperience);

        if ($workExperience->company_logo) {
            Storage::disk('public')->delete($workExperience->company_logo);
        }

        $workExperience->delete();

        return redirect()->route('work-experiences.index')->with('success', 'Work experience deleted successfully.');
    }

    private function authorizeOwner(WorkExperience $workExperience)
    {
        if ($workExperience->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
