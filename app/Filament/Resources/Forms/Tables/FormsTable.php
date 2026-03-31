<?php

namespace App\Filament\Resources\Forms\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\DeleteAction;
use Filament\Tables;

class FormsTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->fontFamily('Aammu'), // CHANGED from family() to fontFamily()

                \Filament\Tables\Columns\TextColumn::make('slug')
                    ->color('gray')
                    ->fontFamily('MVTyper'), // Also updated here for consistency

                \Filament\Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Status'),

                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                \Filament\Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Only'),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}