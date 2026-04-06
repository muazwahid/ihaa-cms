<?php

namespace App\Filament\Resources\Staff\Pages;

use App\Filament\Resources\Staff\StaffResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Widgets\StaffStats;

class ListStaff extends ListRecords
{
    protected static string $resource = StaffResource::class;

    public function getBreadcrumbs(): array
    {
        return [
            // The URL for the Resource index (Posts)
            static::getResource()::getUrl('index') => __('navigation.resources.staff'),
            
            // The current "List" label (you can leave this out if you just want the Resource name)
            '#' => __('navigation.breadcrumbs.list'), 
        ];
    }
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->label(__('navigation.breadcrumbs.new') . ' ' . __('navigation.resources.staff_single')),
        ];
    }
    public function getTitle(): string
    {
        return __('navigation.resources.staff');
    }
    protected function getHeaderWidgets(): array
    {
        return [
            StaffStats::class,
        ];
    }
}
