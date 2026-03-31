<?php

namespace App\Filament\Resources\Banners\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Models\Banner;
use Filament\Tables;

class BannersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label(__('navigation.column.image_path'))
                    ->disk('public') // <--- This tells Filament where the file actually is
                    ->visibility('public')
                    ->square()
                    ->size(40),
                TextColumn::make('link_url')
                ->label(__('navigation.column.slide_title')) 
                    ->state(fn (Banner $record): string => $record->getTranslation('title', app()->getLocale()))
                    ->searchable()
                    ->sortable(),
                IconColumn::make('is_active')
                ->label(__('navigation.column.status')) 
                    ->boolean(),
                TextColumn::make('sort_order')
                ->label(__('navigation.column.sort')) 
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                ->label(__('navigation.column.createdAt')) 
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                ->label(__('navigation.column.updateAt')) 
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make()
                ->label(__('actions.edit')),
                DeleteAction::make()
                ->label(__('actions.delete')),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                    ->label(__('actions.bulk-delete')),
                ])
                ->label(__('actions.bulk-action')),
            ]);
    }
}
