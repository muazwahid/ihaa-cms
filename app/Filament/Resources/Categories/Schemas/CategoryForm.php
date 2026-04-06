<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;
use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Filament\Forms\Components\Select;
use App\Models\Category;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('navigation.form.category-details'))
                ->schema([
                    TranslatableTabs::make()
                        ->locales([
                            'dv' => 'ދިވެހި',
                            'en' => 'English',
                        ])
                        ->columnSpanFull()
                        ->schema([
                            TextInput::make('name')
                                ->label(__('navigation.form.cat_name'))
                                ->required()
                                ->lazy()
                                ->afterStateUpdated(function ($state, Set $set, $component) {
                                    // Generate slug from English tab
                                    if (str_ends_with($component->getName(), '.en')) {
                                        $set('slug', Str::slug($state));
                                    }
                                })
                                ->extraInputAttributes(fn ($component) => [
                                    'style' => str_ends_with($component->getStatePath(), '.dv') 
                                        ? 'font-family: "MVTyper", sans-serif !important; direction: rtl; text-align: right; font-size: 1.25rem !important;' 
                                        : 'direction: ltr; text-align: left;',
                                ])
                                ->extraAttributes(fn ($component) => [
                                    'class' => str_ends_with($component->getStatePath(), '.dv') ? 'dv-title-input' : '',
                                ]),
                        ]),
                    
                    TextInput::make('slug')
                        ->label(__('navigation.form.slug'))
                        ->required()
                        ->unique('categories', 'slug', ignoreRecord: true),

                    Select::make('parent_id')
                        ->label(fn () => app()->getLocale() === 'dv' ? 'މައި ކެޓަގަރީ' : 'Parent Category')
                        ->relationship('parent', 'name') // 'name' works because of Spatie Translatable support in Filament
                        ->searchable()
                        ->placeholder(fn () => app()->getLocale() === 'dv' ? 'މައި ކެޓަގަރީއެއް ނެތް' : 'None (Root Category)')
                        // Prevent a category from being its own parent
                        ->disabled(fn (?Category $record) => $record === null ? false : false) 
                        ->options(function (?\App\Models\Category $record) { 
                            $query = \App\Models\Category::query();
                            
                            if ($record) {
                                $query->where('id', '!=', $record->id);
                            }
                            
                            return $query->pluck('name', 'id');
                    }),
                ]),
        ]);
    }
}