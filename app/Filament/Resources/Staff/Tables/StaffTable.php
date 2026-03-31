<?php

namespace App\Filament\Resources\Staff\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
class StaffTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order', 'asc')
            ->columns([
                ImageColumn::make('photo')
                    ->label(__('navigation.column.photo'))
                    ->circular(),

                TextColumn::make('name')
                    ->label(__('navigation.form.fullName'))
                    ->searchable()
                    ->sortable()
                    ->description(function ($record) {
                        $locale = app()->getLocale();
                        return $record->getTranslation('designation', $locale);
                    })
                    ->extraAttributes(function ($record) {
                        // Apply RTL styles only if the current language is Dhivehi
                        if (app()->getLocale() === 'dv') {
                            return [
                                'style' => 'font-family: "MVTyper", sans-serif; direction: rtl; text-align: right;',
                            ];
                        }
                        return [];
                    }),

                // Updated to use the relationship
                TextColumn::make('category.name')
                    ->label(__('navigation.column.category'))
                    ->badge()
                    // Fetch translation based on current app locale
                    ->formatStateUsing(fn ($record) => $record->category?->getTranslation('name', app()->getLocale()))
                    ->color('info'), // You can set a static color or logic based on slug

                TextInputColumn::make('sort_order')
                    ->label(__('navigation.form.sort_order'))
                    ->sortable()
                    ->rules(['required', 'integer']),

                ToggleColumn::make('is_active')
                    ->label(__('navigation.form.is_active')),

                TextColumn::make('updated_at')
                    ->label(__('navigation.form.updated_at'))
                    ->dateTime('d/m/Y')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Updated to dynamic relationship filter
                SelectFilter::make('staff_category_id')
                    ->label(__('navigation.form.category'))
                    ->relationship('category', 'name')
                    // Ensures the filter dropdown shows correctly translated names
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->getTranslation('name', app()->getLocale()))
                    ->preload()
                    ->searchable(),
            ])
            ->actions([
                EditAction::make()->label(__('actions.edit')),
                DeleteAction::make()->label(__('actions.delete')),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label(__('navigation.column.bulk-delete')),
                ])->label(__('navigation.column.bulk-action')),
            ]);
    }
}