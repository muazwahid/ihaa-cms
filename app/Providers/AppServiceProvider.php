<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Livewire\Livewire;
use App\Settings\GeneralSettings;
use App\Filament\Pages\Auth\Login;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(GeneralSettings $settings): void
    {
        // 1. Configure Dhivehi/English Tabs for Filament
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

        // 2. Set the global language from your Settings table
        $locale = $settings->site_language ?? config('app.locale');
        config(['app.locale' => $locale]);
        app()->setLocale($locale);

        // 3. Fix Livewire paths for your specific subfolder setup
        Livewire::setScriptRoute(function ($handle) {
            return Route::get('/council-cms/public/vendor/livewire/livewire.js', $handle);
        });

        Livewire::setUpdateRoute(function ($handle) {
            return Route::post('/council-cms/public/livewire/update', $handle);
        });
        //since custom login page is ceated
        Livewire::component('app.filament.pages.auth.login', Login::class);
    }
}