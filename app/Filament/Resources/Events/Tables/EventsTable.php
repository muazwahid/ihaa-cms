<?php

namespace App\Filament\Resources\Events\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\Action; 
use Filament\Tables\Filters\Filter;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str; 
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('start_date', 'desc')
            ->columns([
                ImageColumn::make('photo')
                    ->circular()
                    ->defaultImageUrl(url('/images/placeholder-event.jpg')),

                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->description(fn ($record) => Str::limit(strip_tags($record->getTranslation('description', app()->getLocale())), 50)),

                TextColumn::make('start_date')
                    ->label('Date & Time')
                    ->date('d M Y')
                    ->description(fn ($record) => $record->event_time ? \Carbon\Carbon::parse($record->event_time)->format('h:i A') : 'Time TBD')
                    ->sortable(),

                TextColumn::make('venue')
                    ->label('Venue')
                    ->searchable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'upcoming' => 'info',
                        'ongoing' => 'warning',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),

                IconColumn::make('news_generated')
                    ->label('News Made')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-circle')
                    ->color(fn ($state) => $state ? 'success' : 'gray'),
            ])
            ->actions([
                // IN-TABLE CONVERSION ACTION
                Action::make('convert_to_news')
                    ->label('Create News')
                    ->icon('heroicon-m-document-duplicate')
                    ->color('success')
                    // Hide if date hasn't passed OR news already exists
                    ->visible(fn ($record) => $record->start_date->isPast() && !$record->news_generated)
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $newsCategory = \App\Models\Category::where('slug', 'news')->first();
                        
                        \App\Models\Post::create([
                            'title' => $record->title,
                            'content' => $record->description,
                            'category_id' => $newsCategory?->id,
                            'featured_image' => $record->photo,
                            'status' => 'draft',
                            'published_at' => now(),
                        ]);

                        $record->update(['news_generated' => true]);
                        
                        Notification::make()->title('News draft created!')->success()->send();
                                        EditAction::make()->label(__('actions.edit'));
                DeleteAction::make()->label(__('actions.delete'));
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
                    ->label(__('actions.bulk-delete')),
                ])
                ->label(__('actions.bulk-action')),
            ]);
            
    }
}