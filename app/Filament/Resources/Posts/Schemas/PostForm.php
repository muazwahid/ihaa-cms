<?php

namespace App\Filament\Resources\Posts\Schemas;

use Gemini\Laravel\Facades\Gemini;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor; // Changed from Textarea
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;
use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;


class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('navigation.form.post-content'))
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
                                                    ->generateContent("Translate the following text to {$targetLang}. Return ONLY the translated sentence:\n\n{$state}");
                                                
                                                $set($targetField, trim($result->text()));

                                                // Auto-generate slug if translating from English
                                                if ($isEnglish) {
                                                    $set('slug', \Illuminate\Support\Str::slug($state));
                                                }
                                            } catch (\Exception $e) {
                                                // Fail silently or add notification here
                                            }
                                        })
                                )
                                ->extraInputAttributes(fn ($component) => [
                                    'style' => str_ends_with($component->getStatePath(), '.dv') 
                                        ? 'font-family: "MVTyper", sans-serif !important; direction: rtl; text-align: right; font-size: 1.25rem !important;' 
                                        : 'direction: ltr; text-align: left;',
                                ])
                                ->extraAttributes(fn ($component) => [
                                    'class' => str_ends_with($component->getStatePath(), '.dv') ? 'dv-title-input' : '',
                                ]),
                            // Content converted to RichEditor
                            RichEditor::make('content')
                                ->label(__('navigation.form.content'))
                                ->required()
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
                                                    ->generateContent("Translate to {$targetLang}. Return ONLY HTML content. Preserve all formatting:\n\n{$state}");
                                                $set($targetField, trim($result->text()));
                                            } catch (\Exception $e) {}
                                        })
                                )
                                // 1. Target the text input area specifically
                                ->extraInputAttributes(fn ($component) => [
                                    'style' => str_ends_with($component->getStatePath(), '.dv') 
                                        ? 'font-family: "MVTyper", sans-serif !important; direction: rtl; text-align: right;' 
                                        : 'direction: ltr; text-align: left;',
                                ])
                                // 2. Target the outer wrapper for the RTL layout and your custom CSS class
                                ->extraAttributes(fn ($component) => [
                                    'style' => str_ends_with($component->getStatePath(), '.dv') ? 'direction: rtl;' : 'direction: ltr;',
                                    'class' => str_ends_with($component->getStatePath(), '.dv') ? 'dv-rich-editor' : '',
                                ])
                        ]),
                ]),

            Section::make(__('navigation.form.settings-media'))
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('slug')
                            ->label(__('navigation.form.slug'))
                            ->required()
                            ->unique(ignorable: fn ($record) => $record),
                    Select::make('category_id')
                        ->label(__('navigation.form.category'))
                        ->relationship(
                            name: 'category', 
                            titleAttribute: 'name' 
                        )
                        // This is the fix: It manually extracts the translation for the dropdown
                        ->getOptionLabelFromRecordUsing(fn ($record) => $record->getTranslation('name', app()->getLocale()))
                        ->searchable()
                        ->preload()
                        ->required()
                        ->native(false),
                                        ]),

                    FileUpload::make('featured_image')
                        ->label(__('navigation.form.featured_image'))
                        ->image()
                        ->directory('posts'),

                    Grid::make(3)->schema([
                        Toggle::make('is_featured')->label(__('navigation.form.is_featured')),
                        Toggle::make('show_sidebar')->default(true)->label(__('navigation.form.show_sidebar')),
                        
                        Select::make('status')
                            ->label(__('navigation.form.status'))
                            ->options([
                                'draft' => __('navigation.form.status_draft'),
                                'published' => __('navigation.form.status_published'),
                            ])
                            ->default('draft')
                            ->required(),
                    ]),

                    Textarea::make('sidebar_config')
                       ->label(__('navigation.form.sidebar_config'))
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