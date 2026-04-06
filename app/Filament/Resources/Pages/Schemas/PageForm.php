<?php

namespace App\Filament\Resources\Pages\Schemas;

use App\Models\Page;
use Gemini\Laravel\Facades\Gemini;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;
use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Filament\Forms\Components\FileUpload;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

                    // MAIN CONTENT AREA (Left 2 columns)
                    Section::make(__('navigation.form.page_content'))
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

                                                        if ($isEnglish) {
                                                            $set('slug', Str::slug($state));
                                                        }
                                                    } catch (\Exception $e) {}
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
                                        ->extraInputAttributes(fn ($component) => [
                                            'style' => str_ends_with($component->getStatePath(), '.dv') 
                                                ? 'font-family: "MVTyper", sans-serif !important; direction: rtl; text-align: right;' 
                                                : 'direction: ltr; text-align: left;',
                                        ])
                                        ->extraAttributes(fn ($component) => [
                                            'style' => str_ends_with($component->getStatePath(), '.dv') ? 'direction: rtl;' : 'direction: ltr;',
                                            'class' => str_ends_with($component->getStatePath(), '.dv') ? 'dv-rich-editor' : '',
                                        ]),
                                ]),
                        ]),

                    // SIDEBAR AREA (Right 1 column)
                    Section::make(__('navigation.form.settings'))
                        ->schema([
                            TextInput::make('slug')
                                ->label(__('navigation.form.slug'))
                                ->required()
                                ->unique(Page::class, 'slug', ignoreRecord: true),

                            FileUpload::make('featured_image')
                                ->label(__('navigation.form.featured_image'))
                                ->image()
                                ->directory('pages')
                                ->imageEditor(),

                            Select::make('parent_id')
                                ->label(__('navigation.form.parent_page'))
                                ->relationship('parent', 'title')
                                ->placeholder(__('navigation.form.none'))
                                ->getOptionLabelFromRecordUsing(fn ($record) => $record->getTranslation('title', app()->getLocale()))
                                ->searchable()
                                ->preload()
                                ->native(false),

                            // Status and Sort Order in 2 columns
                            Grid::make(2)
                                ->schema([
                                    Select::make('status')
                                        ->label(__('navigation.form.status'))
                                        ->options([
                                            'draft' => __('navigation.form.status_draft'),
                                            'published' => __('navigation.form.status_publish'),
                                        ])
                                        ->default('draft')
                                        ->required()
                                        ->native(false),

                                    TextInput::make('sort_order')
                                        ->label(__('navigation.form.sort_order'))
                                        ->numeric()
                                        ->default(0),
                                ]),

                            Toggle::make('is_visible')
                                ->label(__('navigation.form.show_in_menu'))
                                ->default(true),
                        ])->columnSpan(1),
                ]);
    }
}