<?php

namespace App\Http\Controllers\public;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;

class AboutController extends Controller
{
    public function index()
    {
        $profile = Profile::first();

        $skills = Skill::orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $experiences = Experience::orderByDesc('currently_working')
            ->orderByDesc('start_date')
            ->get();

        $education = Education::orderByDesc('currently_studying')
            ->orderByDesc('start_date')
            ->get();

        $projects = Project::where('is_active', true)
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'success' => true,
            'profile' => $profile,
            'skills' => $skills,
            'experiences' => $experiences,
            'education' => $education,
            'projects' => $projects,
        ]);
    }
}
