<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'skills' => $skills,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'category' => [
                'nullable',
                'string',
                'max:100',
            ],
            'percentage' => [
                'required',
                'integer',
                'min:0',
                'max:100',
            ],
            'icon' => [
                'nullable',
                'string',
                'max:255',
            ],
            'is_active' => [
                'boolean',
            ],
            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $skill = Skill::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Skill added successfully.',
            'skill' => $skill,
        ], 201);
    }

    public function update(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'category' => [
                'nullable',
                'string',
                'max:100',
            ],
            'percentage' => [
                'required',
                'integer',
                'min:0',
                'max:100',
            ],
            'icon' => [
                'nullable',
                'string',
                'max:255',
            ],
            'is_active' => [
                'boolean',
            ],
            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $skill->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Skill updated successfully.',
            'skill' => $skill->fresh(),
        ]);
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();

        return response()->json([
            'success' => true,
            'message' => 'Skill deleted successfully.',
        ]);
    }
}
