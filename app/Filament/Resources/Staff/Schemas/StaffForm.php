<?php

namespace App\Filament\Resources\Staff\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\DatePicker; // Import the DatePicker
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Gemini\Laravel\Facades\Gemini;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;
use Filament\Actions\Action;

class StaffForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            // SECTION 1: Staff Details
            Section::make(__('navigation.form.staff_details'))
                ->schema([
                    TranslatableTabs::make()
                        ->locales([
                            'dv' => 'ދިވެހި',
                            'en' => 'English',
                        ])
                        ->columnSpanFull()
                        ->schema([
                            TextInput::make('name')
                                ->label(__('navigation.form.fullName'))
                                ->required()
                                ->extraInputAttributes(fn ($component) => [
                                    'style' => str_ends_with($component->getStatePath(), '.dv') 
                                        ? 'font-family: "MVTyper", sans-serif !important; direction: rtl; text-align: right; font-size: 1.25rem !important;' 
                                        : 'direction: ltr; text-align: left;',
                                ])
                                ->extraAttributes(fn ($component) => [
                                    'class' => str_ends_with($component->getStatePath(), '.dv') ? 'dv-title-input' : '',
                                ]),

                            TextInput::make('designation')
                                ->label(__('navigation.form.designation'))
                                ->required()
                                ->extraInputAttributes(fn ($component) => [
                                    'style' => str_ends_with($component->getStatePath(), '.dv') 
                                        ? 'font-family: "MVTyper", sans-serif !important; direction: rtl; text-align: right; font-size: 1.25rem !important;' 
                                        : 'direction: ltr; text-align: left;',
                                ])
                                ->extraAttributes(fn ($component) => [
                                    'class' => str_ends_with($component->getStatePath(), '.dv') ? 'dv-title-input' : '',
                                ]),

                            RichEditor::make('responsibility')
                                ->label(__('navigation.form.responsibility'))
                                ->required()
                                ->hintAction(
                                    Action::make('translateContent')
                                        ->label('Translate ✨')
                                        ->icon('heroicon-m-sparkles')
                                        ->action(function (string|null $state, Set $set, $component) {
                                            if (blank($state)) return;

                                            $isEnglish = str_ends_with($component->getName(), '.en');
                                            $targetLang = $isEnglish ? 'Dhivehi' : 'English';
                                            
                                            // FIXED: Changed 'content' to 'responsibility' to match field name
                                            $targetField = $isEnglish ? 'responsibility.dv' : 'responsibility.en';

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
                                // 2. Target the outer wrapper for the RTL layout and your custom CSS class
                                ->extraAttributes(fn ($component) => [
                                    'style' => str_ends_with($component->getStatePath(), '.dv') ? 'direction: rtl;' : 'direction: ltr;',
                                    'class' => str_ends_with($component->getStatePath(), '.dv') ? 'dv-rich-editor' : '',
                                ])
                        ]),
                ]),

            // SECTION 2: Staff Settings & Employment Dates
            Section::make(__('navigation.form.staff_other_info'))
                ->schema([
                    Grid::make(2)->schema([
                       Select::make('staff_category_id')
                            ->label(__('navigation.form.category'))
                            ->relationship('category', 'name')
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->getTranslation('name', app()->getLocale()))
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required()
                            ->createOptionForm([
                                Grid::make(1)->schema([
                                    TextInput::make('name.en')
                                        ->label('Name (English)')
                                        ->required()
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(fn ($state, $set) => $set('slug', \Illuminate\Support\Str::slug($state))),
                                    
                                    TextInput::make('name.dv')
                                        ->label('Name (Dhivehi)')
                                        ->required()
                                        ->extraInputAttributes(['style' => 'font-family: "MVTyper"; direction: rtl; text-align: right;']),
                                        
                                    \Filament\Forms\Components\Hidden::make('slug'),
                                ]),
                            ])
                            ->createOptionUsing(function (array $data): int {
                                // Ensure you use the fully qualified class name or import it at the top
                                $category = \App\Models\StaffCategory::create([
                                    'name' => [
                                        'en' => $data['name']['en'],
                                        'dv' => $data['name']['dv'],
                                    ],
                                    'slug' => $data['slug'] ?? \Illuminate\Support\Str::slug($data['name']['en']),
                                ]);

                                return $category->id;
                            }),

                        TextInput::make('email')
                            ->label(__('navigation.form.email'))
                            ->email(),

                        TextInput::make('contact_num')
                            ->label(__('navigation.form.contact_num'))
                            ->tel(),

                        TextInput::make('sort_order')
                            ->label(__('navigation.form.sort_order'))
                            ->numeric()
                            ->default(0),

                        // NEW FIELD: Joined Date
                        DatePicker::make('joined_at')
                            ->label(__('navigation.form.joined_date'))
                            ->native(false)
                            ->displayFormat('d/m/Y'),

                        // NEW FIELD: Resigned/Last Date
                        DatePicker::make('resigned_at')
                            ->label(__('navigation.form.resigned_date'))
                            ->native(false)
                            ->displayFormat('d/m/Y'),
                    ]),

                    FileUpload::make('photo')
                        ->label(__('navigation.column.photo'))
                        ->image()
                        ->avatar() 
                        ->imageEditor()
                        ->circleCropper() 
                        ->directory('staff')
                        ->required(),

                    Grid::make(3)->schema([
                        Toggle::make('is_active')
                            ->label(__('navigation.form.is_active'))
                            ->default(true),
                    ]),
                ]),
        ]);
    }
}