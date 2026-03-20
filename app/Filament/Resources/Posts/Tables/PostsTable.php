<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Models\Post;

class PostsTable
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

            TextColumn::make('category')
                ->label(__('navigation.column.category'))
                ->badge(),

            ImageColumn::make('featured_image')
                ->label(__('navigation.column.featured_image'))
                ->circular(),

            IconColumn::make('is_featured')
                ->label(__('navigation.column.is_featured'))
                ->boolean(),

            TextColumn::make('status')
                ->label(__('navigation.column.status'))
                ->badge(),
        ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}