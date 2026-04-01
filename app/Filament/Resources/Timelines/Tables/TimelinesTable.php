<?php

namespace App\Filament\Resources\Timelines\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;

class TimelinesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('event_date', 'desc')
            ->columns([
                ImageColumn::make('image')
                    ->label(__('navigation.column.photo'))
                    ->circular(),

                TextColumn::make('title')
                    ->label(__('navigation.form.title'))
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    // Keep the mapping info as a subtle description to save space
                    ->description(fn ($record): ?string => match ($record->category) {
                        'achievement' => "Achievement: " . ($record->achievement?->getTranslation('name', app()->getLocale()) ?? '—'),
                        'project' => "Project: " . ($record->project?->getTranslation('name', app()->getLocale()) ?? '—'),
                        default => null,
                    }),

                // Updated Date Column
                TextColumn::make('event_date')
                    ->label(__('navigation.form.event_date'))
                    ->date('d F Y') // Example: 01 April 2026
                    ->sortable()
                    ->color('gray')
                    ->description(fn ($record) => $record->event_date->format('l')), // Shows day of the week (e.g., Wednesday)

                TextColumn::make('category')
                    ->label(__('navigation.column.category'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'project' => 'warning',
                        'achievement' => 'success',
                        'history' => 'info',
                        default => 'gray',
                    }),

                IconColumn::make('is_active')
                    ->label(__('navigation.column.is_active'))
                    ->boolean(),
                    
                TextColumn::make('sort_order')
                    ->label(__('navigation.form.sort_order'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->label(__('navigation.form.category'))
                    ->options([
                        'project' => 'Projects',
                        'achievement' => 'Achievements',
                        'history' => 'History',
                    ]),
            ]);
    }
}