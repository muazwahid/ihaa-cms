<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\ViewAction;
use App\Filament\Resources\Posts\PostResource;
use Filament\Actions\Action; 
use Illuminate\Contracts\Support\Htmlable;

class EditProject extends EditRecord
{
    protected static string $resource = ProjectResource::class;

public function getBreadcrumbs(): array
    {
        return [
            // Points to the localized "Posts" list page
            static::getResource()::getUrl('index') => __('navigation.resources.posts'),
            
            // Current page label (replacing "Edit")
            '#' => __('actions.edit'),
        ];
    }
        /**
     * Localizes the top-right header buttons.
     */
    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
                ->label(__('navigation.form.view')),
            
            DeleteAction::make()
                ->label(__('navigation.form.delete')),
        ];
    }
        public function getTitle(): string | Htmlable
    {
        return __('navigation.resources.to_project') . ' ' . __('actions.edit');
    }

    /**
     * Localizes the "Save changes" button.
     */
    protected function getSaveFormAction(): Action
    {
        return parent::getSaveFormAction()
            ->label(__('actions.save'));
    }

    /**
     * Localizes the "Cancel" button.
     */
    protected function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->label(__('actions.cancel'));
    }

}
