<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Skill;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::where('user_id', Auth::id())
            ->orderBy('category')
            ->orderBy('level', 'desc')
            ->get();
            
        // Group skills by category for better display
        $groupedSkills = $skills->groupBy('category');
        
        return view('skills.index', compact('groupedSkills'));
    }

    public function create()
    {
        return view('skills.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'level' => ['required', 'integer', 'min:0', 'max:100'],
            'experience' => ['nullable', 'string', 'max:100'],
            'category' => ['required', 'string', 'max:255'],
        ]);

        $validatedData['user_id'] = Auth::id();
        Skill::create($validatedData);

        return redirect()->route('skills.index')->with('success', 'Skill added successfully.');
    }

    public function edit(Skill $skill)
    {
        $this->authorizeOwner($skill);
        return view('skills.edit', compact('skill'));
    }

    public function update(Request $request, Skill $skill)
    {
        $this->authorizeOwner($skill);

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'level' => ['required', 'integer', 'min:0', 'max:100'],
            'experience' => ['nullable', 'string', 'max:100'],
            'category' => ['required', 'string', 'max:255'],
        ]);

        $skill->update($validatedData);

        return redirect()->route('skills.index')->with('success', 'Skill updated successfully.');
    }

    public function destroy(Skill $skill)
    {
        $this->authorizeOwner($skill);
        $skill->delete();

        return redirect()->route('skills.index')->with('success', 'Skill deleted successfully.');
    }

    private function authorizeOwner(Skill $skill)
    {
        if ($skill->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
