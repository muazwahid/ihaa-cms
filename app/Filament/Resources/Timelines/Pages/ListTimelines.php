<?php

namespace App\Filament\Resources\Timelines\Pages;

use App\Filament\Resources\Timelines\TimelineResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTimelines extends ListRecords
{
    protected static string $resource = TimelineResource::class;

    public function getBreadcrumbs(): array
    {
        return [
            // The URL for the Resource index (Posts)
            static::getResource()::getUrl('index') => __('navigation.resources.timelines'),
            
            // The current "List" label (you can leave this out if you just want the Resource name)
            '#' => __('navigation.breadcrumbs.list'), 
        ];
    }
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->label(__('navigation.breadcrumbs.new') . ' ' . __('navigation.resources.timeline')),
        ];
    }
    public function getTitle(): string
    {
        return __('navigation.resources.timelines');
    }
}
