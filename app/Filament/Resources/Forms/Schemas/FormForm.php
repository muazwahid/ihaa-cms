<?php

namespace App\Filament\Resources\Forms\Schemas;

use Filament\Forms\Components\Builder;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class FormForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Form Settings')
                    ->description('Basic information about this form')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                        TextInput::make('slug')->required()->unique(ignoreRecord: true),
                        Toggle::make('is_active')->label('Publicly Available')->default(true),
                    ])->columns(3),

                Builder::make('content')
                    ->label('Form Designer')
                    ->blocks([
                        // 1. ADVANCED TEXT INPUT
                        Builder\Block::make('input')
                            ->label('Text Field')
                            ->icon('heroicon-m-pencil-square')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('label')->required(),
                                    Select::make('type')
                                        ->options([
                                            'text' => 'Short Text',
                                            'email' => 'Email',
                                            'number' => 'Number',
                                            'password' => 'Password',
                                            'tel' => 'Phone Number',
                                        ])->default('text'),
                                ]),
                                Grid::make(3)->schema([
                                    TextInput::make('placeholder'),
                                    TextInput::make('default_value')->label('Default Value'),
                                    Toggle::make('required')->inline(false),
                                ]),
                            ]),

                        // 2. RICH CONTENT / INSTRUCTIONS
                        Builder\Block::make('content_block')
                            ->label('Description Text')
                            ->icon('heroicon-m-document-text')
                            ->schema([
                                RichEditor::make('content')
                                    ->label('Text to show on form (Instructions, etc.)'),
                            ]),

                        // 3. DATE & TIME PICKER
                        Builder\Block::make('date_picker')
                            ->label('Date Picker')
                            ->icon('heroicon-m-calendar')
                            ->schema([
                                TextInput::make('label')->required(),
                                Grid::make(2)->schema([
                                    DatePicker::make('min_date'),
                                    DatePicker::make('max_date'),
                                ]),
                                Toggle::make('required'),
                            ]),

                        // 4. FILE UPLOAD (Crucial for Councils)
                        Builder\Block::make('file_upload')
                            ->label('Document Upload')
                            ->icon('heroicon-m-arrow-up-tray')
                            ->schema([
                                TextInput::make('label')->required(),
                                Grid::make(2)->schema([
                                    TextInput::make('max_size')->label('Max Size (MB)')->numeric()->default(2),
                                    TextInput::make('allowed_types')->placeholder('pdf,jpg,png'),
                                ]),
                                Toggle::make('multiple')->label('Allow multiple files'),
                            ]),

                        // 5. COLOR PICKER (For styling or branding)
                        Builder\Block::make('color_picker')
                            ->label('Color Selection')
                            ->icon('heroicon-m-swatch')
                            ->schema([
                                TextInput::make('label')->required(),
                                ColorPicker::make('default_color'),
                            ]),

                        // 6. MULTI-SELECT / REPEATER
                        Builder\Block::make('dropdown')
                            ->label('Dropdown Menu')
                            ->icon('heroicon-m-chevron-down')
                            ->schema([
                                TextInput::make('label')->required(),
                                Repeater::make('options')
                                    ->schema([
                                        TextInput::make('option_label')->required()->placeholder('Text User Sees'),
                                        TextInput::make('option_value')->required()->placeholder('Database Value'),
                                    ])->grid(2)->reorderableWithButtons(),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->collapsible()
                    ->cloneable()
                    ->inset() // Gives it a more "Graphical" inset look
                    ->blockIcons() // Shows icons in the "Add" menu
                    ->blockNumbers(), 
            ]);
    }
}