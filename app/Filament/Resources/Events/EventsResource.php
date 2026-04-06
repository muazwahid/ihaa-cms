<?php

namespace App\Filament\Resources\Events;

use App\Filament\Resources\Events\Pages\CreateEvents;
use App\Filament\Resources\Events\Pages\EditEvents;
use App\Filament\Resources\Events\Pages\ListEvents;
use App\Filament\Resources\Events\Schemas\EventsForm;
use App\Filament\Resources\Events\Tables\EventsTable;
use App\Models\Event; // Corrected singular model
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EventsResource extends Resource
{
    // Fix: Use Event::class, not Events::class
    protected static ?string $model = Event::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    // Fix: Usually events use 'title' as the main attribute, not 'name'
    protected static ?string $recordTitleAttribute = 'title';

    public static function getNavigationLabel(): string
    {
        return __('navigation.resources.events'); 
    }

    public static function getPluralModelLabel(): string
    {
        return __('navigation.resources.events');
    }

    public static function getModelLabel(): string
    {
        return __('navigation.resources.event');
    }

    public static function form(Schema $schema): Schema
    {
        return EventsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EventsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEvents::route('/'),
            'create' => CreateEvents::route('/create'),
            'edit' => EditEvents::route('/{record}/edit'),
        ];
    }
}