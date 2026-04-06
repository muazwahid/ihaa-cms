<?php

namespace App\Providers\Filament;

use Filament\Support\Facades\FilamentView;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use App\Filament\Widgets\IhaaInfoWidget;
use App\Filament\Widgets\LatestActivity;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\SpatieLaravelTranslatablePlugin;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Assets\Css;
use Filament\Navigation\NavigationItem;
use App\Filament\Pages\Dashboard;
use App\Filament\Pages\Auth\Login;

class CAdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
                FilamentView::registerRenderHook(
            'panels::body.start',
            fn (): string => app()->getLocale() === 'dv' ? '<div dir="rtl">' : '<div>'
        );
        return $panel
            ->default()
            ->id('c-admin')
            ->path('c-admin')
            //->login()
            ->login(\App\Filament\Pages\Auth\Login::class) // Custom Login
            // Use a closure so it checks the locale dynamically
            
            ->brandName(fn () => app()->getLocale() === 'dv' ? 'އިހާ ސީއެމްއެސް' : 'Iha CMS')
            ->brandLogo(asset('images/logo.png'))
            ->assets([
                Css::make('custom-style', public_path('css/app/custom-style.css')),
            ])
            // Use MVTyper as the default body font
            ->font('MVTyper') 
            //->maxContentWidth(\Filament\Support\Enums\MaxWidth::Full);
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                \App\Filament\Pages\Dashboard::class, // This is enough!
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                IhaaInfoWidget::class,
                LatestActivity::class,
            ])
            ->middleware([
                \App\Http\Middleware\SetAdminLocale::class, // Add this first
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,

            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
            
    
    }
}
