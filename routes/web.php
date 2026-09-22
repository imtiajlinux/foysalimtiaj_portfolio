<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\EducationController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\GalleryCategoryController;
use App\Http\Controllers\Admin\GalleryImageController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\AboutController;



/*
|--------------------------------------------------------------------------
| Public Website
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('app');
});

Route::get('/data/home', [HomeController::class, 'index']);

Route::post('/data/messages', [MessageController::class, 'store']);
Route::get('/data/projects', [ProjectController::class, 'projectData']);
Route::get('/data/gallery', [GalleryImageController::class, 'getFrontimages']);
Route::get('/data/about', [AboutController::class, 'index']);

Route::get('/projects', function () {
    return view('app');
});

Route::get('/gallery', function () {
    return view('app');
});

Route::get('/contact', function () {
    return view('app');
});
Route::get('/about', function () {
    return view('app');
});


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', function () {
    return view('app');
})->name('login');

Route::post('/admin/login', [
    LoginController::class,
    'login'
])->name('admin.login');

Route::get('/admin/auth/user', [
    LoginController::class,
    'user'
])->name('admin.auth.user');

Route::post('/admin/logout', [
    LoginController::class,
    'logout'
])->middleware('auth')->name('admin.logout');


/*
| Protected Admin Area
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {


    Route::get('/admin/data/dashboard', [DashboardController::class,'index']);
    Route::get('/admin/data/messages/unread-count', [DashboardController::class, 'unreadMessageCount']);


    Route::get('/admin/data/profile', [ ProfileController::class,'index']);
    Route::post('/admin/data/profile', [ProfileController::class,'update']);

    Route::post('/admin/data/settings/password', [ LoginController::class,'changePassword' ]);

    Route::get('/admin/data/experiences', [ExperienceController::class,'index']);
    Route::post('/admin/data/experiences', [ExperienceController::class,'store']);
    Route::put('/admin/data/experiences/{experience}', [ExperienceController::class,'update' ]);
    Route::delete('/admin/data/experiences/{experience}', [ ExperienceController::class, 'destroy' ]);


    Route::get('/admin/data/educations', [ EducationController::class, 'index' ]);
    Route::post('/admin/data/educations', [ EducationController::class,'store']);
    Route::put('/admin/data/educations/{education}', [EducationController::class,'update']);
    Route::delete('/admin/data/educations/{education}', [EducationController::class,'destroy']);


    Route::get('/admin/data/skills', [SkillController::class,'index']);
    Route::post('/admin/data/skills', [SkillController::class,'store']);
    Route::put('/admin/data/skills/{skill}', [SkillController::class,'update']);
    Route::delete('/admin/data/skills/{skill}', [SkillController::class,'destroy']);


    Route::get('/admin/data/projects', [ProjectController::class,'index']);
    Route::post('/admin/data/projects', [ProjectController::class,'store']);
    Route::put('/admin/data/projects/{project}', [ProjectController::class,'update']);
    Route::delete('/admin/data/projects/{project}', [ProjectController::class,'destroy']);


    Route::get('/admin/data/messages', [MessageController::class, 'index']);
    Route::get('/admin/data/messages/{message}', [MessageController::class, 'show']);
    Route::put('/admin/data/messages/{message}/read', [MessageController::class, 'markAsRead']);
    Route::delete('/admin/data/messages/{message}', [MessageController::class, 'destroy']);


    Route::get('/admin/data/gallery/categories', [GalleryCategoryController::class, 'index']);
    Route::post('/admin/data/gallery/categories', [GalleryCategoryController::class, 'store']);
    Route::put('/admin/data/gallery/categories/{category}', [GalleryCategoryController::class, 'update']);
    Route::delete('/admin/data/gallery/categories/{category}', [GalleryCategoryController::class, 'destroy']);

    Route::get('/admin/data/gallery/images', [GalleryImageController::class, 'index']);
    Route::post('/admin/data/gallery/images', [GalleryImageController::class, 'store']);
    Route::post('/admin/data/gallery/images/{image}', [GalleryImageController::class, 'update']);
    Route::delete('/admin/data/gallery/images/{image}', [GalleryImageController::class, 'destroy']);

    Route::get('/admin/{any?}', function () {
        return view('app');
    })->where('any', '.*');

});