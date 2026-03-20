<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Livewire\Livewire;
use App\Settings\GeneralSettings;

// ... imports

class AppServiceProvider extends ServiceProvider
{
    // ... register method

    /**
     * Bootstrap any application services.
     */
    public function boot(GeneralSettings $settings): void // <--- Add this here
    {
        // 1. Configure Dhivehi/English Tabs
        TranslatableTabs::configureUsing(function (TranslatableTabs $component) {
            $component
                ->locales(['dv', 'en'])
                ->localesLabels([
                    'dv' => 'ދިވެހި',
                    'en' => 'English',
                ])
                ->addDirectionByLocale()
                ->addSetActiveTabThatHasValue();
        });

        // 2. Set the language from your Settings table
        // This will now work because $settings is injected above
        config(['app.locale' => $settings->site_language]);
        app()->setLocale($settings->site_language);

        // 3. Fix Livewire paths for the subfolder setup
        \Livewire\Livewire::setScriptRoute(function ($handle) {
            return \Illuminate\Support\Facades\Route::get('/council-cms/public/vendor/livewire/livewire.js', $handle);
        });

        \Livewire\Livewire::setUpdateRoute(function ($handle) {
            return \Illuminate\Support\Facades\Route::post('/council-cms/public/livewire/update', $handle);
        });
    }
}