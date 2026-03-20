<?php

namespace App\Filament\Resources\Banners\Pages;

use App\Filament\Resources\Banners\BannerResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditBanner extends EditRecord
{

    protected static string $resource = BannerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // REMOVE: LocaleSwitcher::make(), 
            // (You will use the tabs inside the form instead)
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}