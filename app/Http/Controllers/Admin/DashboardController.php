<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use App\Models\Skill;
use App\Models\Project;
use App\Models\Experience;
use App\Models\Message;
use App\Models\Education;
use App\Models\GalleryImage;


class DashboardController extends Controller
{
    public function index()
    {
        $skills = Skill::all();
        $projects = Project::all();
        $experiences = Experience::all();
        $messages = Message::all();
        $educations = Education::all();
        $galleryImages = GalleryImage::all();

        return response()->json([
            'skills' => $skills,
            'projects' => $projects,
            'experiences' => $experiences,
            'messages' => $messages,
            'educations' => $educations,
            'galleryImages' => $galleryImages,
        ]);
    }

    public function unreadMessageCount()
    {
        return response()->json([
            'count' => Message::where('is_read', false)->count(),
        ]);
    }
}
