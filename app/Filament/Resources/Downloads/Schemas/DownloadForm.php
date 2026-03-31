<?php

namespace App\Filament\Resources\Downloads\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;

class DownloadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Grid::make(1) // Parent grid set to 2 columns
                ->schema([
                    
                    // Left Column: Main Details
                    Section::make(__('navigation.form.download_details'))
                        ->schema([
                            TranslatableTabs::make()
                                ->locales([
                                    'dv' => 'ދިވެހި',
                                    'en' => 'English',
                                ])
                                ->columnSpanFull()
                                ->schema([
                                                                    TextInput::make('title') 
                                        ->label(__('navigation.form.title'))
                                        ->required()
                                        ->lazy()
                                        ->extraInputAttributes(fn ($component) => [
                                            'style' => str_ends_with($component->getStatePath(), '.dv') 
                                                ? 'font-family: "MVTyper", sans-serif !important; direction: rtl; text-align: right; font-size: 1.25rem !important;' 
                                                : 'direction: ltr; text-align: left;',
                                        ]),
                                ]),
                            Select::make('category')
                                 ->label(__('navigation.form.cat_name'))
                                ->options([
                                    'form' => 'Application Form',
                                    'report' => 'Annual Report',
                                ])
                                ->native(false)
                                ->required(),
                        ])
                        ->columnSpan(2), // Takes half width

                    // Right Column: File & Settings
                    Section::make(__('navigation.form.download_file_status'))
                        ->schema([
                            FileUpload::make('file_path')
                                ->disk('public')
                                ->label(__('navigation.form.download_file_name'))
                                ->directory('downloads')
                                ->preserveFilenames()
                                ->acceptedFileTypes(['application/pdf', 'application/msword', 'image/*'])
                                ->required(),

                            Grid::make(2) // Sub-grid for toggle and sort order
                                ->schema([
                                    Toggle::make('is_active')
                                        ->label(__('navigation.form.is_active'))
                                        ->default(true)
                                        ->columnSpan(1),

                                    TextInput::make('sort_order')
                                        ->label(__('navigation.form.sort_order'))
                                        ->numeric()
                                        ->default(0)
                                        ->columnSpan(1),
                                ]),
                        ])
                        ->columnSpan(1), // Takes half width
                ]),
        ]);
    }
}