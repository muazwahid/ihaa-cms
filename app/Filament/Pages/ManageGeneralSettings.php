<?php

namespace App\Filament\Pages;

use App\Settings\GeneralSettings;
use Filament\Forms\Components\Select;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use BackedEnum;

class ManageGeneralSettings extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = GeneralSettings::class;

    // Change the parameter type from 'Form' to 'Schema'
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([ // Note: Some versions use 'components' instead of 'schema' here
                Section::make('Localization')
                    ->description('Set the primary language for the council portal.')
                    ->schema([
                        Select::make('site_language')
                            ->label('Default Language')
                            ->options([
                                'en' => 'English',
                                'dv' => 'ދިވެހި',
                            ])
                            ->native(false)
                            ->required(),
                    ]),
            ]);
    }
}