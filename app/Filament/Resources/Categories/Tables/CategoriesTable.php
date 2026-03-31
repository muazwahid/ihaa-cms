<?php

namespace App\Filament\Resources\Categories\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('navigation.form.cat_name'))
                    ->sortable()
                    ->searchable()
                    // Uses Aammu font for the list view as per your CSS
                    ->extraAttributes(['class' => 'dhivehi-title-column']),

                TextColumn::make('slug')
                    ->label(__('navigation.form.slug'))
                    ->badge()
                    ->color('gray'),

                TextColumn::make('created_at')
                    ->label(__('navigation.form.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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