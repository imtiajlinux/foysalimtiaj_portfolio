<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ExperienceController extends Controller
{
    public function index()
    {
        $experiences = Experience::orderBy('sort_order')
            ->orderByDesc('start_date')
            ->get();

        return response()->json([
            'success' => true,
            'experiences' => $experiences,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company' => [
                'required',
                'string',
                'max:255',
            ],

            'position' => [
                'required',
                'string',
                'max:255',
            ],

            'employment_type' => [
                'nullable',
                'string',
                'max:100',
            ],

            'location' => [
                'nullable',
                'string',
                'max:255',
            ],

            'start_date' => [
                'required',
                'date',
            ],

            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],

            'currently_working' => [
                'boolean',
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

            'company_logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        if ($request->boolean('currently_working')) {
            $validated['end_date'] = null;
        }

        $validated['currently_working'] = $request->boolean('currently_working');

        if ($request->hasFile('company_logo')) {
            $validated['company_logo'] = $this->uploadLogo(
                $request->file('company_logo')
            );
        }

        $experience = Experience::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Experience added successfully.',
            'experience' => $experience,
        ], 201);
    }

    public function update(Request $request, Experience $experience)
    {
        $validated = $request->validate([
            'company' => [
                'required',
                'string',
                'max:255',
            ],

            'position' => [
                'required',
                'string',
                'max:255',
            ],

            'employment_type' => [
                'nullable',
                'string',
                'max:100',
            ],

            'location' => [
                'nullable',
                'string',
                'max:255',
            ],

            'start_date' => [
                'required',
                'date',
            ],

            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],

            'currently_working' => [
                'boolean',
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

            'company_logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        if ($request->boolean('currently_working')) {
            $validated['end_date'] = null;
        }

        $validated['currently_working'] = $request->boolean('currently_working');

        if ($request->hasFile('company_logo')) {
            $this->deleteLogo($experience->company_logo);

            $validated['company_logo'] = $this->uploadLogo(
                $request->file('company_logo')
            );
        }

        $experience->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Experience updated successfully.',
            'experience' => $experience->fresh(),
        ]);
    }

    public function destroy(Experience $experience)
    {
        $this->deleteLogo($experience->company_logo);

        $experience->delete();

        return response()->json([
            'success' => true,
            'message' => 'Experience deleted successfully.',
        ]);
    }

    private function uploadLogo($file)
    {
        $directory = public_path('uploads/experiences');

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

        $file->move($directory, $filename);

        return 'uploads/experiences/' . $filename;
    }

    private function deleteLogo(?string $path): void
    {
        if (!$path) {
            return;
        }

        $fullPath = public_path($path);

        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }
}
