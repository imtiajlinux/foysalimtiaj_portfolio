<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GalleryImageController extends Controller
{
    public function index(Request $request)
    {
        $query = GalleryImage::with('category');

        if ($request->filled('category_id')) {
            $query->where(
                'gallery_category_id',
                $request->category_id
            );
        }

        $images = $query
            ->orderBy('gallery_category_id')
            ->orderBy('priority')
            ->orderByDesc('id')
            ->get();

        return response()->json([
            'success' => true,
            'images' => $images,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',

            'items.*.gallery_category_id' => [
                'required',
                'integer',
                'exists:gallery_categories,id',
            ],

            'items.*.image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'items.*.title' => [
                'required',
                'string',
                'max:255',
            ],

            'items.*.short_description' => [
                'nullable',
                'string',
                'max:500',
            ],

            'items.*.long_description' => [
                'nullable',
                'string',
            ],

            'items.*.priority' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'items.*.is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        $uploadPath = public_path('uploads/gallery');

        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        $createdImages = [];

        foreach ($validated['items'] as $index => $item) {

            $file = $request->file(
                "items.$index.image"
            );

            $filename = Str::uuid() . '.' .
                $file->getClientOriginalExtension();

            $file->move(
                $uploadPath,
                $filename
            );

            $galleryImage = GalleryImage::create([
                'gallery_category_id' =>
                $item['gallery_category_id'],

                'image' => $filename,

                'title' =>
                $item['title'],

                'short_description' =>
                $item['short_description'] ?? null,

                'long_description' =>
                $item['long_description'] ?? null,

                'priority' =>
                $item['priority'] ?? 0,

                'is_active' =>
                isset($item['is_active'])
                    ? (bool) $item['is_active']
                    : true,
            ]);

            $createdImages[] = $galleryImage;
        }

        return response()->json([
            'success' => true,
            'message' =>
            count($createdImages) .
                ' image(s) uploaded successfully.',
            'images' => $createdImages,
        ], 201);
    }

    public function update(
        Request $request,
        GalleryImage $image
    ) {
        $validated = $request->validate([
            'gallery_category_id' => [
                'required',
                'integer',
                'exists:gallery_categories,id',
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'short_description' => [
                'nullable',
                'string',
                'max:500',
            ],

            'long_description' => [
                'nullable',
                'string',
            ],

            'priority' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        if ($request->hasFile('image')) {

            $oldImage = public_path(
                'uploads/gallery/' . $image->image
            );

            if (File::exists($oldImage)) {
                File::delete($oldImage);
            }

            $uploadPath = public_path(
                'uploads/gallery'
            );

            if (!File::exists($uploadPath)) {
                File::makeDirectory(
                    $uploadPath,
                    0755,
                    true
                );
            }

            $file = $request->file('image');

            $filename = Str::uuid() . '.' .
                $file->getClientOriginalExtension();

            $file->move(
                $uploadPath,
                $filename
            );

            $validated['image'] = $filename;
        }

        $validated['is_active'] =
            $request->boolean('is_active');

        $image->update($validated);

        return response()->json([
            'success' => true,
            'message' =>
            'Gallery image updated successfully.',
            'image' => $image->fresh('category'),
        ]);
    }

    public function destroy(GalleryImage $image)
    {
        $imagePath = public_path(
            'uploads/gallery/' . $image->image
        );

        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        $image->delete();

        return response()->json([
            'success' => true,
            'message' =>
            'Gallery image deleted successfully.',
        ]);
    }
}
