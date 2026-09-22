<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\Project;
use App\Models\GalleryCategory;
use App\Models\GalleryImage;

class HomeController extends Controller
{
    public function index()
    {
        $profile = Profile::first();

        $skills = Skill::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $experiences = Experience::orderBy('sort_order')
            ->orderByDesc('start_date')
            ->get();

        $projects = Project::where('is_active', true)
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        $galleryCategories = GalleryCategory::with([
            'images' => function ($query) {
                $query->where('is_active', true)
                    ->orderBy('priority')
                    ->orderByDesc('id')
                    ->take(3);
            }
        ])
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'profile' => $profile,
            'skills' => $skills,
            'experiences' => $experiences,
            'projects' => $projects,
            'gallery_categories' => $galleryCategories,
        ]);
    }
}
