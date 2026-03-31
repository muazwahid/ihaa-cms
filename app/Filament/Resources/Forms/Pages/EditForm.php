<?php

namespace App\Filament\Resources\Forms\Pages;

use App\Filament\Resources\Forms\FormResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditForm extends EditRecord
{
    protected static string $resource = FormResource::class;

    protected function getFormSchemaComponentContainerMaxWidth(): string 
    {
        return 'full'; 
    }
    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('preview')
                ->label('Live Preview')
                ->color('gray')
                ->icon('heroicon-m-eye')
                // This opens the link in a new tab
                ->openUrlInNewTab()
                ->url(fn ($record) => route('forms.preview', $record->slug))
                // Optional: Only show if the form has a slug
                ->visible(fn ($record) => $record && $record->slug),
                
            \Filament\Actions\DeleteAction::make(),
        ];
    }
}
