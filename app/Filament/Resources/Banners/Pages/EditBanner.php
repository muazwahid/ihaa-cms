<?php

namespace App\Filament\Resources\Banners\Pages;

use App\Filament\Resources\Banners\BannerResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Actions\Action; // Added for the Save/Cancel buttons
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditBanner extends EditRecord
{
    protected static string $resource = BannerResource::class;

    public function getBreadcrumbs(): array
    {
        return [
            // This link goes to the list page
            static::getResource()::getUrl('index') => __('navigation.resources.banners'),
            
            // This is the current page label (replacing "Edit")
            '#' => __('actions.edit'),
        ];
    }
    public function getTitle(): string | Htmlable
    {
        return __('navigation.resources.to_banner') . ' ' . __('actions.edit');
    }

    /**
     * Fixes the "Save changes" button
     */
    protected function getSaveFormAction(): Action
    {
        return parent::getSaveFormAction()
            ->label(__('actions.save'));
    }

    /**
     * Fixes the "Cancel" button
     */
    protected function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->label(__('actions.cancel'));
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
                ->label(__('navigation.form.view')),
            
            DeleteAction::make()
                ->label(__('navigation.form.delete')),
        ];
    }
}