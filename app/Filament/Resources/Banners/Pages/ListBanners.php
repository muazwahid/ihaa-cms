<?php

namespace App\Filament\Resources\Banners\Pages;

use App\Filament\Resources\Banners\BannerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBanners extends ListRecords
{
    protected static string $resource = BannerResource::class;
    public function getBreadcrumbs(): array
    {
        return [
            // This replaces "List" with your menu label (e.g., ސްލައިޑްސް)
            '#' => __('navigation.resources.banners'),
        ];
    }
protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->label(__('navigation.new') . ' ' . __('navigation.resources.banner')),
        ];
    }
}
