<?php

namespace App\Filament\Resources\Banners\Pages;

use App\Filament\Resources\Banners\BannerResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions\Action;
use Illuminate\Contracts\Support\Htmlable;

class CreateBanner extends CreateRecord
{
    protected static string $resource = BannerResource::class;

    /**
     * Fixes the Page Title & Breadcrumb
     */
    public function getTitle(): string | Htmlable
    {
        return __('actions.create') . ' ' . __('navigation.sideMenu.banner');
    }

    /**
     * Fixes the "Create" button
     */
    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->label(__('actions.create'));
    }

    /**
     * Fixes the "Create & create another" button
     */
    protected function getCreateAnotherFormAction(): Action
    {
        return parent::getCreateAnotherFormAction()
            ->label(__('actions.create_and_new') ?? __('actions.create'));
    }

    /**
     * Fixes the "Cancel" button
     */
    protected function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->label(__('actions.cancel'));
    }
}