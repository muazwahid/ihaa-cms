<?php

namespace App\Filament\Resources\Timelines\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Filament\Schemas\Components\Utilities\Get;
class TimelineForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
                                // MAIN: Content
                Section::make('Detailed Information')
                    ->schema([
                        TranslatableTabs::make()
                            ->locales(['dv' => 'ދިވެހި', 'en' => 'English'])
                            ->schema([
                                TextInput::make('title')
                                    ->required()
                                    ->extraInputAttributes(fn ($component) => [
                                    'style' => str_ends_with($component->getStatePath(), '.dv') 
                                        ? 'font-family: "MVTyper", sans-serif !important; direction: rtl; text-align: right; font-size: 1.25rem !important;' 
                                        : 'direction: ltr; text-align: left;',
                                    ])
                                    ->extraAttributes(fn ($component) => [
                                        'class' => str_ends_with($component->getStatePath(), '.dv') ? 'dv-title-input' : '',
                                    ]),

                                RichEditor::make('description')
                                    ->extraInputAttributes(fn ($component) => [
                                    'style' => str_ends_with($component->getStatePath(), '.dv') 
                                        ? 'font-family: "MVTyper", sans-serif !important; direction: rtl; text-align: right;' 
                                        : 'direction: ltr; text-align: left;',
                                ])
                                // 2. Target the outer wrapper for the RTL layout and your custom CSS class
                                ->extraAttributes(fn ($component) => [
                                    'style' => str_ends_with($component->getStatePath(), '.dv') ? 'direction: rtl;' : 'direction: ltr;',
                                    'class' => str_ends_with($component->getStatePath(), '.dv') ? 'dv-rich-editor' : '',
                                ]),
                            ]),
                    ]),
                    // SIDEBAR: Settings
                Section::make('Event Metadata')
                    ->schema([
                        DatePicker::make('event_date')
                            ->label('Date of Event')
                            ->required()
                            ->native(false),

                        Select::make('category')
                            ->options([
                                'project' => __('navigation.form.timeline_project_milestone'),
                                'achievement' => __('navigation.form.timeline_achievement'),
                                'history' => __('navigation.form.timeline_historical_event'),
                            ])
                            ->required()
                            ->native(false)
                            ->live(),
                        // DYNAMIC FIELD: Shown only if 'project' is selected
                        Select::make('project_id')
                            ->label('Related Project')
                            ->relationship('project', 'name') // Use the 'project' relation and show the 'name' column
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->getTranslation('name', app()->getLocale()))
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required() // This only triggers if the field is visible
                            ->visible(fn (Get $get) => $get('category') === 'project')
                            ->columnSpanFull(),
                        
                        Select::make('achievement_id')
                            ->label('Related Achievement')
                            ->relationship('achievement', 'name')
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->getTranslation('name', app()->getLocale()))
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required()
                            ->visible(fn (Get $get) => $get('category') === 'achievement')
                            // Allow creating achievement on the fly
                            ->createOptionForm([
                                TextInput::make('name.en')->label('Achievement Name (EN)')->required(),
                                TextInput::make('name.dv')->label('Achievement Name (DV)')->required()
                                    ->extraInputAttributes(['style' => 'font-family: "MVTyper"; direction: rtl;']),
                                RichEditor::make('description.en')->label('Details (EN)'),
                                RichEditor::make('description.dv')->label('Details (DV)')
                                    ->extraInputAttributes(['style' => 'direction: rtl;']),
                            ])
                            ->columnSpanFull(),

                        FileUpload::make('image')
                            ->image()
                            ->directory('timeline')
                            ->imageEditor(),

                        Toggle::make('is_active')
                            ->label('Active Milestone')
                            ->default(true),
                            
                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                    ]),


            ]);
    }
}