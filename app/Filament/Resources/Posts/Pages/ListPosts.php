<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

        public function getBreadcrumbs(): array
    {
        return [
            // The URL for the Resource index (Posts)
            static::getResource()::getUrl('index') => __('navigation.sideMenu.posts'),
            
            // The current "List" label (you can leave this out if you just want the Resource name)
            '#' => __('navigation.breadcrumbs.list'), 
        ];
    }
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->label(__('navigation.new') . ' ' . __('navigation.resources.post')),
        ];
    }
    public function getTitle(): string
    {
        return __('navigation.resources.posts');
    }

}
