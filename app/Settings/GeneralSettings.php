<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    // This MUST match the name in your Select::make('site_language')
    public string $site_language; 

    public static function group(): string
    {
        return 'general';
    }
}