<?php

namespace App\Filament\Resources\Staff;

use App\Filament\Resources\StaffResource\Pages;
use App\Models\Staff;
use Filament\Schemas\Schema;
use Filament\Forms\Form; // IMPORTANT: This must be the form class
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Resources\Concerns\Translatable;
use BackedEnum;
use App\Filament\Resources\Staff\Pages\CreateStaff;
use App\Filament\Resources\Staff\Pages\EditStaff;
use App\Filament\Resources\Staff\Pages\ListStaff;
use App\Filament\Resources\Staff\Schemas\StaffForm; // Make sure this file exists
use App\Filament\Resources\Staff\Tables\StaffTable; // Make sure this file exists

class StaffResource extends Resource
{

    protected static ?string $model = Staff::class;
    
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-users';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationLabel(): string
    {
        return __('navigation.resources.staff');
    }

    // This changes the Heading on the List page
    public static function getPluralModelLabel(): string
    {
        return __('navigation.resources.staff');
    }

    public static function getCreateActionLabel(): string
    {
        return __('navigation.new') . ' ' . __('navigation.resources.post');
    }
    public static function getModelLabel(): string
    {
        return __('navigation.resources.staff');
    }
    public static function form(Schema $schema): Schema
    {
        return StaffForm::configure($schema);
    }
    public static function table(Table $table): Table
    {
        return StaffTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStaff::route('/'),
            'create' => CreateStaff::route('/create'),
            'edit' => EditStaff::route('/{record}/edit'),
        ];
    }
}