<?php

namespace App\Filament\Resources\Posts\Schemas;

use Gemini\Laravel\Facades\Gemini;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section; // New: Correct structural namespace
use Filament\Schemas\Components\Grid;    // New: Correct structural namespace
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;
use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Post Content')
                ->schema([
                    TranslatableTabs::make()
                        ->locales([
                            'dv' => 'ދިވެހި',
                            'en' => 'English',
                        ])
                        ->columnSpanFull()
                        ->schema([
                            Textarea::make('title')
                                ->required()
                                ->rows(2)
                                ->hintAction(
                                    \Filament\Actions\Action::make('translateTitle')
                                        ->label('Translate ✨')
                                        ->icon('heroicon-m-sparkles')
                                        ->action(function (string|null $state, Set $set, $component) {
                                            if (blank($state)) return;

                                            $isEnglish = str_ends_with($component->getName(), '.en');
                                            $targetLang = $isEnglish ? 'Dhivehi' : 'English';
                                            $targetField = $isEnglish ? 'title.dv' : 'title.en';

                                            try {
                                                $result = Gemini::generativeModel(model: 'gemini-3-flash-preview')
                                                    ->generateContent("Translate the following text to {$targetLang}. Return ONLY the translated sentence. No explanations, no options, no quotes:\n\n{$state}");
                                                $set($targetField, trim($result->text()));

                                                if ($isEnglish) {
                                                    $set('slug', Str::slug($state));
                                                }
                                            } catch (\Exception $e) {}
                                        })
                                )
                                ->extraInputAttributes(['style' => 'direction: auto; font-family: "Faruma", sans-serif;']),

                            Textarea::make('content')
                                ->required()
                                ->rows(8)
                                ->hintAction(
                                    \Filament\Actions\Action::make('translateContent')
                                        ->label('Translate ✨')
                                        ->icon('heroicon-m-sparkles')
                                        ->action(function (string|null $state, Set $set, $component) {
                                            if (blank($state)) return;

                                            $isEnglish = str_ends_with($component->getName(), '.en');
                                            $targetLang = $isEnglish ? 'Dhivehi' : 'English';
                                            $targetField = $isEnglish ? 'content.dv' : 'content.en';

                                            try {
                                                $result = Gemini::generativeModel(model: 'gemini-3-flash-preview')
                                                    ->generateContent("Translate the following text to {$targetLang}. Return ONLY the translated text. Preserve paragraph structure:\n\n{$state}");
                                                $set($targetField, trim($result->text()));
                                            } catch (\Exception $e) {}
                                        })
                                )
                                ->extraInputAttributes(['style' => 'direction: auto; font-family: "Faruma", sans-serif;']),
                        ]),
                ]),

            Section::make('Settings & Media')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignorable: fn ($record) => $record),
                        Select::make('category')
                            ->options([
                                'news' => 'News',
                                'notices' => 'Notices',
                                'reports' => 'Reports'
                            ])
                            ->required(),
                    ]),

                    FileUpload::make('featured_image')
                        ->image()
                        ->directory('posts'),

                    Grid::make(3)->schema([
                        Toggle::make('is_featured')->label('Featured Post'),
                        Toggle::make('show_sidebar')->default(true),
                        Select::make('status')
                            ->options(['draft' => 'Draft', 'published' => 'Published'])
                            ->default('draft')
                            ->required(),
                    ]),

                    Textarea::make('sidebar_config')
                        ->label('Sidebar Configuration (JSON)')
                        ->placeholder('{"key": "value"}')
                        ->columnSpanFull()
                        ->rules([
                            fn (): \Closure => function (string $attribute, $value, \Closure $fail) {
                                if (is_null(json_decode($value)) && json_last_error() !== JSON_ERROR_NONE) {
                                    $fail('The :attribute must be a valid JSON string.');
                                }
                            },
                        ]),
                ]),
        ]);
    }
}