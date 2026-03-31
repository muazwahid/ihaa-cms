<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Actions\Action; 
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    /**
     * Replaces "Edit" and "List" in the breadcrumbs with localized labels.
     */
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
    /**
     * Sets the main page title (H1) and browser tab title.
     */
    public function getTitle(): string | Htmlable
    {
        return __('navigation.resources.to_post') . ' ' . __('actions.edit');
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