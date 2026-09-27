<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialMedia;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    public function index()
    {
        $socialMedia = SocialMedia::orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return response()->json([
            'success' => true,
            'social_media' => $socialMedia,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'link' => 'required|url|max:500',
            'icon' => 'nullable|string',
            'status' => 'required|in:a,d,p',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $socialMedia = SocialMedia::create([
            'name' => $validated['name'],
            'link' => $validated['link'],
            'icon' => $validated['icon'] ?? null,
            'status' => $validated['status'],
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Social media created successfully.',
            'social_media' => $socialMedia,
        ], 201);
    }

    public function update(Request $request, SocialMedia $socialMedia)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'link' => 'required|url|max:500',
            'icon' => 'nullable|string',
            'status' => 'required|in:a,d,p',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $socialMedia->update([
            'name' => $validated['name'],
            'link' => $validated['link'],
            'icon' => $validated['icon'] ?? null,
            'status' => $validated['status'],
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Social media updated successfully.',
            'social_media' => $socialMedia->fresh(),
        ]);
    }

    public function destroy(SocialMedia $socialMedia)
    {
        $socialMedia->delete();

        return response()->json([
            'success' => true,
            'message' => 'Social media deleted successfully.',
        ]);
    }
}
