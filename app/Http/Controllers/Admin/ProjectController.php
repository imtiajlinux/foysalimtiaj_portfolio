<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('sort_order')
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'success' => true,
            'projects' => $projects,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'category' => [
                'nullable',
                'string',
                'max:100',
            ],
            'short_description' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'technologies' => [
                'nullable',
                'string',
            ],
            'project_url' => [
                'nullable',
                'url',
                'max:255',
            ],
            'github_url' => [
                'nullable',
                'url',
                'max:255',
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],
            'is_featured' => [
                'boolean',
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

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage(
                $request->file('image')
            );
        }

        $project = Project::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Project added successfully.',
            'project' => $project,
        ], 201);
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'category' => [
                'nullable',
                'string',
                'max:100',
            ],
            'short_description' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'technologies' => [
                'nullable',
                'string',
            ],
            'project_url' => [
                'nullable',
                'url',
                'max:255',
            ],
            'github_url' => [
                'nullable',
                'url',
                'max:255',
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],
            'is_featured' => [
                'boolean',
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

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $this->deleteImage($project->image);

            $validated['image'] = $this->uploadImage(
                $request->file('image')
            );
        }

        $project->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Project updated successfully.',
            'project' => $project->fresh(),
        ]);
    }

    public function destroy(Project $project)
    {
        $this->deleteImage($project->image);

        $project->delete();

        return response()->json([
            'success' => true,
            'message' => 'Project deleted successfully.',
        ]);
    }

    private function uploadImage($file)
    {
        $directory = public_path('uploads/projects');

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

        $file->move($directory, $filename);

        return 'uploads/projects/' . $filename;
    }

    private function deleteImage(?string $path): void
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
