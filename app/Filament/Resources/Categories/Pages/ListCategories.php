<?php

namespace App\Filament\Resources\Categories\Pages;

use App\Filament\Resources\Categories\CategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    public function getBreadcrumbs(): array
    {
        return [
            // The URL for the Resource index (Posts)
            static::getResource()::getUrl('index') => __('navigation.resources.categories'),
            
            // The current "List" label (you can leave this out if you just want the Resource name)
            '#' => __('navigation.breadcrumbs.list'), 
        ];
    }
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->label(__('navigation.new') . ' ' . __('navigation.resources.category')),
        ];
    }
}
