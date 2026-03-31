<?php

namespace App\Filament\Resources\Forms\Pages;

use App\Filament\Resources\Forms\FormResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions\Action;
use Illuminate\Contracts\Support\Htmlable;

class CreateForm extends CreateRecord
{
    protected static string $resource = FormResource::class;
    
        public function getTitle(): string | Htmlable
    {
        return __('actions.create') . ' ' . __('navigation.resorces.banner');
    }

    protected function getFormSchemaComponentContainerMaxWidth(): string 
    {
        return 'full'; 
    }
}
