<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Contracts\Support\Htmlable;

class Dashboard extends BaseDashboard
{
    // This controls the Sidebar Label
    public static function getNavigationLabel(): string
    {
        return app()->getLocale() === 'dv' 
            ? (__('filament-panels.pages.dashboard.title') ?? 'ޑޭޝްބޯޑު') 
            : 'Dashboard';
    }

    // This controls the Browser Tab Title
    public function getTitle(): string | Htmlable
    {
        return app()->getLocale() === 'dv' 
            ? (__('filament-panels.pages.dashboard.title') ?? 'ޑޭޝްބޯޑު') 
            : 'Dashboard';
    }

    // This controls the Big Heading on the page
    public function getHeading(): string | Htmlable
    {
        return app()->getLocale() === 'dv' 
            ? (__('filament-panels.pages.dashboard.title') ?? 'ޑޭޝްބޯޑު') 
            : 'Dashboard';
    }
}