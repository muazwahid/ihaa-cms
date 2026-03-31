<?php

namespace App\Filament\Resources\Downloads\Tables;

use Filament\Tables\Table;
use Filament\Actions\Action; // Correct namespace for Table Actions
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Illuminate\Support\Facades\Storage;

class DownloadsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title.en')
                    ->label('Title (EN)')
                    ->description(fn ($record) => $record->title['dv'] ?? '', position: 'below')
                    ->extraAttributes([
                        'style' => 'font-family: "MVTyper", sans-serif;',
                    ])
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category')
                    ->label('Category') 
                    ->badge()
                    ->color('info'),

                ToggleColumn::make('is_active')
                    ->label('Status')

    ->onColor('success')   // green
    ->offColor('danger'),  // red

                TextColumn::make('sort_order')
                    ->label('Sort')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->options([
                        'form' => 'Application Forms',
                        'report' => 'Annual Reports',
                    ]),
            ])
            ->actions([
                // This now works with Filament\Tables\Actions\Action
                Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->url(fn ($record) => asset('storage/' . $record->file_path))
                    //->url(fn ($record) => Storage::url($record->file_path))
                    ->openUrlInNewTab(),

                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}