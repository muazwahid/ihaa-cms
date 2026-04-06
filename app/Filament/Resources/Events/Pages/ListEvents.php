<?php

namespace App\Filament\Resources\Events\Pages;

use App\Filament\Resources\Events\EventsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Widgets\EventStats;

class ListEvents extends ListRecords
{
    protected static string $resource = EventsResource::class;

    
    public function getBreadcrumbs(): array
    {
        return [
            // The URL for the Resource index (Posts)
            static::getResource()::getUrl('index') => __('navigation.resources.events'),
            
            // The current "List" label (you can leave this out if you just want the Resource name)
            '#' => __('navigation.breadcrumbs.list'), 
        ];
    }
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->label(__('navigation.breadcrumbs.new') . ' ' . __('navigation.resources.event')),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            EventStats::class,
        ];
    }
    public function getTitle(): string
    {
        return __('navigation.resources.events');
    }
}
