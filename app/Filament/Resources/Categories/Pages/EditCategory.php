<?php

namespace App\Filament\Resources\Categories\Pages;

use App\Filament\Resources\Categories\CategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Actions\Action; 

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

        public function getBreadcrumbs(): array
    {
        return [
            // Points to the localized "Posts" list page
            static::getResource()::getUrl('index') => __('navigation.resources.category'),
            
            // Current page label (replacing "Edit")
            '#' => __('actions.edit'),
        ];
    }
    public function getTitle(): string | Htmlable
        {
            return __('navigation.resources.to_category') . ' ' . __('actions.edit');
        }
        protected function getSaveFormAction(): Action
    {
        return parent::getSaveFormAction()
            ->label(__('actions.save'));
    }
    protected function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->label(__('actions.cancel'));
    }
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
            ->label(__('actions.delete')),
            ForceDeleteAction::make()
            ->label(__('actions.force_delete')),
            RestoreAction::make()
            ->label(__('actions.restore')),
        ];
    }
    
}
