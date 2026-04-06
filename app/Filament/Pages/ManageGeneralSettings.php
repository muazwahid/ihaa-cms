<?php

namespace App\Filament\Pages;

use App\Settings\GeneralSettings;
use Filament\Forms\Components\Select;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Placeholder;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Storage;
use App\Models\Banner;

use BackedEnum;

class ManageGeneralSettings extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = GeneralSettings::class;
    // 1. Change the name in the Sidebar
    public static function getNavigationLabel(): string
    {
        return __('navigation.resources.general_settings');
    }

    // 2. Change the title at the top of the Page
    public function getTitle(): string
    {
        return __('navigation.resources.general_settings');
    }
    
    // 3. Optional: Change the Heading (If different from title)
    public function getHeading(): string
    {
        return __('navigation.resources.general_settings');
    }
    // Change the parameter type from 'Form' to 'Schema'
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([ // Note: Some versions use 'components' instead of 'schema' here
                Section::make(__('navigation.localization'))
                    ->description(__('navigation.primary_lang_description'))
                    ->schema([
                        // Language Selection
                        Select::make('site_language')
                            ->label(__('navigation.default_language'))
                            ->options([
                                'en' => 'English',
                                'dv' => 'ދިވެހި',
                            ])
                            ->native(false)
                            ->required(),

                        // Primary Font Selection (Usually for Headings/Main UI)
                        Select::make('primary_font')
                            ->label(__('navigation.primary_font'))
                            ->options([
                                'Inter' => 'Inter (Modern Sans)',
                                'Roboto' => 'Roboto',
                                'Poppins' => 'Poppins',
                                'Faruma' => 'Faruma (Dhivehi Standard)',
                                'A_Waheed' => 'A Waheed (Dhivehi Traditional)',
                            ])
                            ->native(false)
                            ->searchable()
                            ->default('Inter'),

                        // Secondary Font Selection (Usually for Body Text)
                        Select::make('secondary_font')
                            ->label(__('navigation.secondary_font'))
                            ->options([
                                'Open Sans' => 'Open Sans',
                                'Lato' => 'Lato',
                                'Montserrat' => 'Montserrat',
                                'Mv_Typer' => 'MV Typer (Dhivehi Body)',
                            ])
                            ->native(false)
                            ->searchable()
                            ->default('Open Sans'),
                    ])
                    ->columns(2),
                Section::make(__('navigation.banner_settings'))
                ->icon('heroicon-o-film')
                    ->schema([
                        // Thumbnail Preview Section
                        Placeholder::make('active_previews')
                            ->label(__('navigation.currently_active_banners'))
                           // ->columnSpanFull() // Force the placeholder to take up the full width of the section
                            ->content(function () {
                                $banners = Banner::where('is_active', true)
                                    ->orderBy('sort_order', 'asc')
                                    ->limit(5)
                                    ->get();

                                if ($banners->isEmpty()) {
                                    return new HtmlString('<p class="text-sm text-gray-500 italic">No banners active.</p>');
                                }

                                // We use !important on the grid-cols to override any Filament wrapper styles
                                $html = '<div style="display: grid !important; grid-template-columns: repeat(5, minmax(0, 1fr)) !important; gap: 1rem; margin-top: 0.5rem; max-width: 500px;">';
                                
                                foreach ($banners as $banner) {
                                    $imageUrl = Storage::disk('public')->url($banner->image_path);
                                    
                                    $html .= "
                                        <div class='flex flex-col items-center justify-start'>
                                            <div class='relative' style='width: 60px; height: 60px;'>
                                                <img src='{$imageUrl}' 
                                                    style='border-radius:20%; width: 60px; height: 60px; object-fit: cover;' 
                                                    class='rounded-lg border border-gray-200 shadow-sm'
                                                    onerror='this.src=\"https://placehold.co/50x50?text=Error\"'>
                                                
                                                <div class='absolute -top-2 -right-2 flex items-center justify-center bg-primary-600 text-white text-[9px] w-4 h-4 rounded-full shadow-sm font-bold border border-white'>
                                                    {$banner->sort_order}
                                                </div>
                                            </div>
                                            <p class='text-[9px] leading-tight text-gray-500 mt-2 text-center break-words w-full px-1' style='display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;'>
                                                {$banner->title_en}
                                            </p>
                                        </div>";
                                }
                                
                                $html .= '</div>';

                                return new HtmlString($html);
                            }),
                        // The Limit Input
                        TextInput::make('banner_limit')
                            ->label(__('navigation.max_banners_to_show'))
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(10)
                            ->default(5)
                            ->required(),
                    ]),
            // --- SECTION 3: PROJECT SETTINGS ---
                Section::make(__('navigation.project_settings'))
                    ->icon('heroicon-o-cube') // This adds the cube icon next to the title
                    ->description(__('navigation.project_settings_desc'))
                    ->schema([
                        // Setting for how many projects to show in the "Recent Projects" grid
                        TextInput::make('homepage_project_limit')
                            ->label(__('navigation.no_of_projects_to_show'))
                            ->numeric()
                            ->default(6),

                        // Toggle to show/hide project categories on the frontend
                        \Filament\Forms\Components\Toggle::make('show_project_categories')
                            ->label(__('navigation.show_categories'))
                            ->default(true)
                            ->inline(false), 
                    ])
                    ->columns(2),
            ]);    
    }
    protected function afterSave(): void
    {
        $data = $this->form->getState();
        $newLocale = $data['site_language'] ?? 'en';

        // 1. Update the session so the middleware sees the new language
        session()->put('locale', $newLocale);
        app()->setLocale($newLocale);

        // 2. Trigger the full page reload after the database has been updated
        $this->js('window.location.reload()');
        
        // 3. Optional: Send a success notification before reload
        \Filament\Notifications\Notification::make()
            ->title(__('navigation.language_updated'))
            ->success()
            ->send();
    }
}