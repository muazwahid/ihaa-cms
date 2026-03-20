<?php

namespace App\Filament\Resources\Projects\Schemas;

use Gemini\Laravel\Facades\Gemini;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Set;
use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;


class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Project Details')
                ->columnSpanFull()
                ->schema([
                    // 1. Full Width Top Area with Translatable Tabs
                    // ... existing imports

TranslatableTabs::make()
        ->locales([
        'dv' => 'ދިވެހި',
        'en' => 'English',
    ])
    ->columnSpanFull()
    ->schema([
        TextInput::make('name')
            ->required()
            ->extraInputAttributes(fn ($component) => [
                'style' => str_ends_with($component->getStatePath(), '.dv') 
                    ? 'font-family: "Aammu", sans-serif !important; direction: rtl; text-align: right;' 
                    : 'direction: ltr; text-align: left;',
            ])
            ->extraAttributes(fn ($component) => [
                // This ensures the font is applied to the wrapper/label area too
                'style' => str_ends_with($component->getStatePath(), '.dv') 
                    ? 'font-family: "Aammu", sans-serif !important; direction: rtl;' 
                    : 'direction: ltr;',
            ]),

        RichEditor::make('description')
            ->extraInputAttributes(fn ($component) => [
                'style' => str_ends_with($component->getStatePath(), '.dv') 
                    ? 'font-family: "MVTyper", sans-serif !important; direction: rtl; text-align: right;' 
                    : 'direction: ltr; text-align: left;',
            ])
            ->extraAttributes(fn ($component) => [
                'style' => str_ends_with($component->getStatePath(), '.dv') 
                    ? 'direction: rtl;' 
                    : 'direction: ltr;',
                // Keep this class so your global CSS can target it
                'class' => str_ends_with($component->getStatePath(), '.dv') ? 'dv-rich-editor' : '',
            ]),
    ]),

                    // 2. Two Column Bottom Area
                    Grid::make(2)
                        ->columnSpanFull()
                        ->schema([
                            // Left Column: Technical Details
                            Grid::make(1)
                                ->schema([
                                    TextInput::make('lat')->label('Latitude')->numeric(),
                                    TextInput::make('lng')->label('Longitude')->numeric(),
                                    TextInput::make('progress_percentage')
                                        ->label('Progress (%)')
                                        ->numeric()
                                        ->default(0),
                                    Select::make('status')
                                        ->options([
                                            'planned' => 'Planned',
                                            'ongoing' => 'Ongoing',
                                            'completed' => 'Completed',
                                        ])
                                        ->required()
                                        ->native(false),
                                ])
                                ->columnSpan(1),

                            // Right Column: Media
                            Grid::make(1)
                                ->schema([
                                    FileUpload::make('image_path')
                                        ->label('Project Featured Image')
                                        ->image()
                                        ->directory('projects')
                                        ->imageEditor()
                                        ->preserveFilenames(),
                                ])
                                ->columnSpan(1),
                        ]),
                ]),
        ]);
    }
}