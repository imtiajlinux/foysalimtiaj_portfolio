<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index()
    {
        $educations = Education::orderBy('sort_order')
            ->orderByDesc('start_date')
            ->get();

        return response()->json([
            'success' => true,
            'educations' => $educations,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'institution' => [
                'required',
                'string',
                'max:255',
            ],
            'degree' => [
                'required',
                'string',
                'max:255',
            ],
            'field_of_study' => [
                'nullable',
                'string',
                'max:255',
            ],
            'location' => [
                'nullable',
                'string',
                'max:255',
            ],
            'start_date' => [
                'nullable',
                'date',
            ],
            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],
            'currently_studying' => [
                'boolean',
            ],
            'grade' => [
                'nullable',
                'string',
                'max:100',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ]);

        $validated['currently_studying'] = $request->boolean('currently_studying');

        if ($validated['currently_studying']) {
            $validated['end_date'] = null;
        }

        $education = Education::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Education added successfully.',
            'education' => $education,
        ], 201);
    }

    public function update(Request $request, Education $education)
    {
        $validated = $request->validate([
            'institution' => [
                'required',
                'string',
                'max:255',
            ],
            'degree' => [
                'required',
                'string',
                'max:255',
            ],
            'field_of_study' => [
                'nullable',
                'string',
                'max:255',
            ],
            'location' => [
                'nullable',
                'string',
                'max:255',
            ],
            'start_date' => [
                'nullable',
                'date',
            ],
            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],
            'currently_studying' => [
                'boolean',
            ],
            'grade' => [
                'nullable',
                'string',
                'max:100',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ]);

        $validated['currently_studying'] = $request->boolean('currently_studying');

        if ($validated['currently_studying']) {
            $validated['end_date'] = null;
        }

        $education->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Education updated successfully.',
            'education' => $education->fresh(),
        ]);
    }

    public function destroy(Education $education)
    {
        $education->delete();

        return response()->json([
            'success' => true,
            'message' => 'Education deleted successfully.',
        ]);
    }
}
