<?php

namespace App\Filament\Resources\Projects\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

// CHANGE THESE: Use the Table specific actions
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

use App\Models\Post;
class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label('') 
                    ->circular(),

                TextColumn::make('name')
                    ->label(__('navigation.column.title'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn ($record) => \Illuminate\Support\Str::limit(strip_tags($record->description), 50)),

                TextColumn::make('status')
                    ->label(__('navigation.column.status')) 
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'planned' => 'gray',
                        'ongoing' => 'warning',
                        'completed' => 'success',
                        default => 'gray',
                    }),

                TextColumn::make('progress_percentage')
                    ->label(__('navigation.column.progress')) 
                    ->numeric()
                    ->suffix('%')
                    ->color('primary')
                    ->sortable(),

                TextColumn::make('lat')
                    ->label('Latitude')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('lng')
                    ->label('Longitude')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'planned' => 'Planned',
                        'ongoing' => 'Ongoing',
                        'completed' => 'Completed',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}