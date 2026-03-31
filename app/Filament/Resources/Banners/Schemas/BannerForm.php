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
                        ->label(__('navigation.form.title'))
                        ->required()
                        ->extraInputAttributes([
                            'class' => 'banner-title-field',
                        ]),

                    Textarea::make('description')
                        ->label(__('navigation.form.description'))
                        ->extraInputAttributes([
                            'class' => 'banner-desc-field',
                        ]),
                                        ]),
                FileUpload::make('image_path')
                ->label(__('navigation.form.image_path'))
                ->disk('public') // <--- Change this to 'public'
                    ->directory('banners') // Files will be in storage/app/public/banners
                    ->visibility('public') // Ensures the file permissions are set for web access
                    ->image()
                    ->preserveFilenames()
                    ->imageEditor() 
                    ->required(),

                TextInput::make('link_url')
                ->label(__('navigation.form.link_url'))
                    ->default(null),

                Toggle::make('is_active')
                ->label(__('navigation.form.is_active'))
                    ->required(),

                TextInput::make('sort_order')
                ->label(__('navigation.form.sort_order'))
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}