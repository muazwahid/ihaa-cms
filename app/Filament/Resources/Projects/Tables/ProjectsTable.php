<?php

namespace App\Filament\Resources\Projects\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
// CORRECT THESE: Table actions must come from the Tables namespace
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;

use App\Models\Project; // Ensure this is Project, not Post

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label(__('navigation.column.photo'))
                    ->circular(),

                TextColumn::make('name')
                    ->label(__('navigation.column.project_name'))
                    // FIX: This prevents the JSON string display
                    ->formatStateUsing(fn ($record) => $record->getTranslation('name', app()->getLocale()))
                    ->searchable()
                    ->sortable()
                    ->extraAttributes(['class' => 'dhivehi-title-column']),

                TextColumn::make('funded_by')
                ->label(__('navigation.column.funded_by'))
                ->formatStateUsing(fn ($state) => null) 
                ->icon(fn (string $state): string => match ($state) {
                    'government' => 'heroicon-m-building-library',
                    'council'    => 'heroicon-m-building-office',
                    'private'    => 'heroicon-m-user',
                    'ngo'        => 'heroicon-m-user-group',
                    default      => 'heroicon-m-question-mark-circle',
                })
                // This loads the localized version based on the database value
                ->tooltip(fn (string $state): string => __("navigation.funded_by_options.{$state}"))
                ->searchable()
                ->sortable()
                ->alignCenter(),

                TextColumn::make('project_cost')
                    ->label(__('navigation.column.project_cost'))
                    ->money('MVR') // Formats as currency
                    ->sortable(),

                TextColumn::make('date_started')
                    ->label(__('navigation.column.started_on'))
                    ->date('d/m/Y')
                    ->sortable(),
                    
                TextColumn::make('progress_percentage')
                    ->label(__('navigation.column.progress'))
                    ->numeric()
                    ->suffix('%')
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state <= 30 => 'danger',
                        $state <= 70 => 'warning',
                        default => 'success',
                    }),

                TextColumn::make('status')
                    ->label(__('navigation.column.status'))
                    ->badge()
                    // Use strtolower to ensure the key matches your lang file (e.g. navigation.status.planned)
                    ->formatStateUsing(fn (string $state): string => __("navigation.status." . strtolower($state)))
                    
                    // Match against lowercase database values
                    ->color(fn (string $state): string => match (strtolower($state)) {
                        'planned'   => 'gray',
                        'ongoing'   => 'warning',
                        'completed' => 'success',
                        'paused'    => 'danger',
                        default     => 'gray',
                    })
                    
                    ->icon(fn (string $state): string => match (strtolower($state)) {
                        'planned'   => 'heroicon-m-calendar-days',
                        'ongoing'   => 'heroicon-m-arrow-path',
                        'completed' => 'heroicon-m-check-badge',
                        'paused'    => 'heroicon-m-pause-circle',
                        default     => 'heroicon-m-question-mark-circle',
                    })
                    ->extraAttributes([
                        'class' => app()->getLocale() === 'dv' ? 'dv-font' : '',
                    ]),
                ToggleColumn::make('is_featured')
                ->label(app()->getLocale() === 'dv' ? 'ފީޗަރ' : 'Featured')
                ->tooltip('Toggle visibility on homepage highlights')
                ->alignCenter(),

            /*filters here*/
            ])
            ->filters([
                // You can add status filters here later
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