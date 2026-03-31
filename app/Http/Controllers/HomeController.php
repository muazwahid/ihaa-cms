<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Project;
use App\Models\Post;
use App\Settings\GeneralSettings; // Import your settings
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(GeneralSettings $settings): View
    {
        return view('home', [
            // 1. Banners: Use your existing model OR your GeneralSettings slides
            // If you are using the Banner model, keep this:
            'banners' => Banner::where('is_active', true)
                ->orderBy('sort_order', 'asc')
                ->get(),

            // 2. Project Highlights: Prioritize 'Featured' projects first
            // If none are marked as featured, fall back to the 3 latest.
            'projects' => Project::where('is_featured', true)
                ->latest()
                ->limit(3)
                ->get()
                ->whenEmpty(fn() => Project::latest()->limit(3)->get()),

            // 3. News items
            'latestNews' => Post::where('category', 'news')
                ->latest()
                ->limit(4)
                ->get(),

            // 4. Official notices
            'notices' => Post::where('category', 'notice')
                ->latest()
                ->limit(4)
                ->get(),
                
            // 5. Global Settings (Optional: if you need site name/logo from settings)
            'siteSettings' => $settings,
        ]);
    }
}