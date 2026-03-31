<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    // This MUST match the name in your Select::make('site_language')
    public string $site_language; 
    public int $banner_limit;
    //public string $primary_font;
    //public string $secondary_font;
    public int $homepage_project_limit;
    public bool $show_project_categories;
    public static function group(): string
    {
        return 'general';
        return __('general_settings');
    }
}