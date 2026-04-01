<?php

namespace App\Filament\Resources\Events\Pages;

use App\Filament\Resources\Events\EventsResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action; 

class EditEvents extends EditRecord
{
    protected static string $resource = EventsResource::class;

    // Inside your ListEvents.php or EditEvent.php
protected function getHeaderActions(): array
{
    return [
        Action::make('convert_to_news')
            ->label('Create News Post')
            ->color('success')
            ->icon('heroicon-o-chat-bubble-left-right')
            // Only show if the event is in the past and news hasn't been made
            ->visible(fn ($record) => $record->start_date->isPast() && !$record->news_generated)
            ->requiresConfirmation()
            ->modalHeading('Generate News from Event')
            ->modalDescription('This will create a new Post under the "News" category using this event\'s data.')
            ->action(function ($record) {
                $post = \App\Models\Post::create([
                    'title' => $record->title, // Spatie handles the JSON copy
                    'content' => $record->description,
                    'category_id' => \App\Models\Category::where('slug', 'news')->first()?->id,
                    'featured_image' => $record->photo,
                    'published_at' => now(),
                    'status' => 'draft', // Save as draft so user can review it
                ]);

                $record->update(['news_generated' => true]);

                Notification::make()
                    ->title('News Draft Created!')
                    ->success()
                    ->body('A new post has been created. You can find it in the News section.')
                    ->send();
            }),
    ];
}
}
