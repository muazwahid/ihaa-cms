<?php

namespace App\Filament\Resources\Banners\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;

class BannerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TranslatableTabs::make() // You might not even need a label here
                    ->locales([
                            'dv' => 'ދިވެހި',
                            'en' => 'English',
                        ])
                    ->schema([
                        Textarea::make('title')
                        ->required()
                        ->extraInputAttributes([
                            'class' => 'banner-title-field',
                        ]),

                    Textarea::make('description')
                        ->extraInputAttributes([
                            'class' => 'banner-desc-field',
                        ]),
                                        ]),
                FileUpload::make('image_path')
                    ->image()
                    ->required(),

                TextInput::make('link_url')
                    ->default(null),

                Toggle::make('is_active')
                    ->required(),

                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}