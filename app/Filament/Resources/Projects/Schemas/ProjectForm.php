<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
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
                    TranslatableTabs::make()
                        ->locales([
                            'dv' => 'ދިވެހި',
                            'en' => 'English',
                        ])
                        ->columnSpanFull()
                        ->schema([
                            TextInput::make('name')
                                ->label(__('navigation.column.project_name'))
                                ->required()
                                ->extraAttributes(fn ($component) => [
                                    'style' => str_ends_with($component->getStatePath(), '.dv') 
                                        ? 'direction: rtl;' 
                                        : 'direction: ltr;',
                                    'class' => str_ends_with($component->getStatePath(), '.dv') ? 'dv-rich-editor' : '',
                                ]),

                            RichEditor::make('description')
                                ->label(__('navigation.column.project_name'))
                                ->required()
                                ->extraAttributes(fn ($component) => [
                                    'style' => str_ends_with($component->getStatePath(), '.dv') 
                                        ? 'direction: rtl;' 
                                        : 'direction: ltr;',
                                    'class' => str_ends_with($component->getStatePath(), '.dv') ? 'dv-rich-editor' : '',
                                ]),

                                
                        ]),

                    // 2. Main Body Grid (Split into Left: Info and Right: Media)
                    Grid::make(2)
                        ->columnSpanFull()
                        ->schema([
                            
                            // LEFT COLUMN: Financials, Timeline, and Status
                            Grid::make(1)
                                ->schema([
                                    
                                    // Row 1: Funded By & Cost
                                    Grid::make(2)->schema([
                                        Select::make('funded_by')
                                            ->label(__('navigation.column.project_by'))
                                            ->options([
                                                'government' => 'Government',
                                                'council' => 'Council',
                                                'private' => 'Private Person',
                                                'ngo' => 'NGO',
                                            ])
                                            ->native(false)
                                            ->required(),

                                        TextInput::make('project_cost')
                                            ->label(__('navigation.column.project_cost'))
                                            ->numeric()
                                            ->prefix('MVR')
                                            ->placeholder('0.00'),
                                    ]),

                                    // Row 2: Dates (Start & End)
                                    Grid::make(2)->schema([
                                        DatePicker::make('date_started')
                                            ->label(__('navigation.column.started_on'))
                                            ->native(false)
                                            ->displayFormat('d/m/Y'),

                                        DatePicker::make('date_ended')
                                            ->label(__('navigation.column.completed_on'))
                                            ->native(false)
                                            ->displayFormat('d/m/Y'),
                                    ]),

                                    // Row 3: Progress & Status
                                    Grid::make(2)->schema([
                                        TextInput::make('progress_percentage')
                                            ->label(__('navigation.column.progress'))
                                            ->numeric()
                                            ->minValue(0)
                                            ->maxValue(100)
                                            ->default(0),

                                        Select::make('status')
                                        ->label(__('navigation.column.project_status'))
                                            ->options([
                                                'planned' => 'Planned',
                                                'ongoing' => 'Ongoing',
                                                'completed' => 'Completed',
                                            ])
                                            ->required()
                                            ->native(false),
                                    ]),
                                ])
                                ->columnSpan(1),

                            // RIGHT COLUMN: Media (Featured Image)
                            Grid::make(1)
                                ->schema([
                                    FileUpload::make('image_path')
                                        ->label(__('navigation.column.project_photo'))
                                        ->image()
                                        ->directory('projects')
                                        ->imageEditor()
                                        ->preserveFilenames(),
                                ])
                                ->columnSpan(1),
                            Toggle::make('is_featured')
                            ->label(__('navigation.column.is_featured'))
                            ->helperText(__('navigation.featured_helper_text.slides'))
                            ->onIcon('heroicon-m-star')
                            ->offIcon('heroicon-o-star')
                        ]),
                ]),
        ]);
    }
}
