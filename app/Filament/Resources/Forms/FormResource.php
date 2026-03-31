<?php

namespace App\Filament\Resources\Forms; // MUST include \Forms because of your folder structure

use App\Filament\Resources\Forms\Pages;
use App\Models\Form as FormModel;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use App\Filament\Resources\Forms\Schemas\FormForm; // Import your custom schema
use App\Filament\Resources\Forms\Tables\FormsTable; // Import your custom table
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Resources\Forms;

class FormResource extends Resource
{
    protected static ?string $model = FormModel::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document';

        public static function getNavigationLabel(): string
    {
        return __('navigation.resources.forms');
    }

    // 2. For the Table Heading and Breadcrumbs
    public static function getPluralModelLabel(): string
    {
        return __('navigation.resources.forms');
    }

    // 3. For the "New/Create" buttons
    public static function getModelLabel(): string
    {
        return __('navigation.resources.forms'); 
    }
    public static function form(Schema $schema): Schema
    {
        // This tells Filament to use your PostForm class
        return FormForm::configure($schema);
    }
    public static function table(Table $table): Table
    {
        // Call the static method from your Table file
        return FormsTable::make($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListForms::route('/'),
            'create' => Pages\CreateForm::route('/create'),
            'edit' => Pages\EditForm::route('/{record}/edit'),
        ];
    }
}