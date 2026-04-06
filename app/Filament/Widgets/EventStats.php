<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class EventStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $now = Carbon::now();

        // 1. Get the Next Upcoming Event (Single Record)
        $nextEvent = Event::where('start_date', '>=', $now)
            ->orderBy('start_date', 'asc')
            ->first();

        // 2. Count all upcoming events
        $upcomingCount = Event::where('start_date', '>=', $now)->count();

        // 3. Count total events (All time)
        $totalCount = Event::count();

        // Logic for Next Event Title/Message
        $nextEventTitle = $nextEvent 
            ? $nextEvent->getTranslation('title', app()->getLocale()) 
            : __('navigation.column.no_upcoming_events');

        $nextEventDate = $nextEvent 
            ? $nextEvent->start_date->format('d M Y') 
            : __('navigation.column.check_back_later');

        return [
            // STAT 1: Next Event Details
            Stat::make(__('navigation.column.next_upcoming_event'), $nextEventTitle)
                ->description($nextEventDate)
                ->descriptionIcon($nextEvent ? 'heroicon-m-sparkles' : 'heroicon-m-information-circle')
                ->color($nextEvent ? 'success' : 'gray'),

            // STAT 2: Count of Upcoming Events
            Stat::make(__('navigation.column.upcoming_events_count'), $upcomingCount)
                ->description(__('navigation.column.scheduled_future'))
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('primary'),

            // STAT 3: Total Events
            Stat::make(__('navigation.column.total_events'), $totalCount)
                ->description(__('navigation.column.all_time_records'))
                ->descriptionIcon('heroicon-m-rectangle-stack')
                ->color('gray'),
        ];
    }
}