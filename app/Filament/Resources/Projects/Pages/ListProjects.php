<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Widgets\ProjectStats;


class ListProjects extends ListRecords
{
    protected static string $resource = ProjectResource::class;

    public function getBreadcrumbs(): array
    {
        return [
            // The URL for the Resource index (Posts)
            static::getResource()::getUrl('index') => __('navigation.resources.projects'),
            
            // The current "List" label (you can leave this out if you just want the Resource name)
            '#' => __('navigation.breadcrumbs.list'), 
        ];
    }
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->label(__('navigation.breadcrumbs.new') . ' ' . __('navigation.resources.project')),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            ProjectStats::class,
        ];
    }
}
