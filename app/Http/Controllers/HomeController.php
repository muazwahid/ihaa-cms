<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Project;
use App\Models\Post;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home', [
            // Sort banners so the Council can control the slide order
            'banners' => Banner::where('is_active', true)
                ->orderBy('sort_order', 'asc')
                ->get(),

            // Ongoing infrastructure projects
            'projects' => Project::latest()->limit(3)->get(),

            // News items (Filter by category 'news')
            'latestNews' => Post::where('category', 'news')
                ->latest()
                ->limit(4)
                ->get(),

            // Official notices and announcements
            'notices' => Post::where('category', 'notice')
                ->latest()
                ->limit(4)
                ->get(),

            // Map data
            'projectLocations' => Project::select('name', 'lat', 'lng', 'progress_percentage')->get(),
        ]);
    }
}