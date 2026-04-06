<?php

namespace App\Filament\Resources\Pages\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Models\Post;

class PagesTable
{
    public static function configure(Table $table): Table
    {
return $table
        ->columns([
            TextColumn::make('title')
                ->label(__('navigation.column.title')) // Clean and simple!
                ->limit(50)
                ->searchable()
                ->sortable(),

            ImageColumn::make('featured_image')
                ->label(__('navigation.column.featured_image'))
                ->circular(),

            TextColumn::make('status')
                ->label(__('navigation.column.status'))
                ->badge()
                ->formatStateUsing(fn ($state) => __("navigation.column.$state"))
                ->color(fn ($state) => match ($state) {
                    'published' => 'success',
                    'draft' => 'primary',
                    default => 'gray',
                })
                ->icon(fn ($state) => match ($state) {
                    'published' => 'heroicon-o-check-circle',
                    'draft' => 'heroicon-o-pencil-square',
                    default => 'heroicon-o-question-mark-circle',
                }),
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
                    ->label(__('navigation.column.bulk-delete')),
                ])
                ->label(__('navigation.column.bulk-action')),
            ]);
    }
}