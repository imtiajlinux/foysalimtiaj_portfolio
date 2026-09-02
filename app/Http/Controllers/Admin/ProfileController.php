<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = Profile::find(1);

        if ($profile) {
            $profile->profile_photo_url = $profile->profile_photo
                ? asset($profile->profile_photo)
                : null;

            $profile->cover_image_url = $profile->cover_image
                ? asset($profile->cover_image)
                : null;
        }

        return response()->json([
            'profile' => $profile,
        ]);
    }

    public function update(Request $request)
    {
        $profile = Profile::find(1);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'date_of_birth' => ['nullable', 'date'],
            'website' => ['nullable', 'url', 'max:255'],
            'short_bio' => ['nullable', 'string'],
            'about' => ['nullable', 'string'],
            'current_address' => ['nullable', 'string'],
            'permanent_address' => ['nullable', 'string'],
            'status' => ['nullable', 'in:a,p,d'],
            'profile_photo' => ['nullable', 'image', 'max:6144'],
            'cover_image' => ['nullable', 'image', 'max:6144'],
        ]);

        $uploadPath = public_path('uploads/profiles');

        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        if ($request->hasFile('profile_photo')) {
            if ($profile?->profile_photo) {
                $oldFile = public_path($profile->profile_photo);

                if (File::exists($oldFile)) {
                    File::delete($oldFile);
                }
            }

            $file = $request->file('profile_photo');

            $filename = 'profile_' . Str::uuid() . '.' . $file->getClientOriginalExtension();

            $file->move($uploadPath, $filename);

            $validated['profile_photo'] = 'uploads/profiles/' . $filename;
        }

        if ($request->hasFile('cover_image')) {
            if ($profile?->cover_image) {
                $oldFile = public_path($profile->cover_image);

                if (File::exists($oldFile)) {
                    File::delete($oldFile);
                }
            }

            $file = $request->file('cover_image');

            $filename = 'cover_' . Str::uuid() . '.' . $file->getClientOriginalExtension();

            $file->move($uploadPath, $filename);

            $validated['cover_image'] = 'uploads/profiles/' . $filename;
        }

        $profile = Profile::updateOrCreate(
            ['id' => 1],
            $validated
        );

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully.',
            'profile' => $profile,
        ]);
    }
}
