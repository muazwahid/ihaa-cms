<?php

namespace App\Filament\Widgets;

use App\Models\Page;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PageStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        // 1. Count Published Pages
        $publishedCount = Page::where('status', 'published')->count();

        // 2. Count Draft Pages
        $draftCount = Page::where('status', 'draft')->count();

        // 3. Count Total Pages
        $totalCount = Page::count();

        return [
            // Published Stat
            Stat::make(__('navigation.column.published'), $publishedCount)
                ->description(__('navigation.column.visible_on_site'))
                ->descriptionIcon('heroicon-m-check-circle', position: 'before')
                ->color('success'),

            // Draft Stat
            Stat::make(__('navigation.column.draft'), $draftCount)
                ->description(__('navigation.column.needs_review'))
                ->descriptionIcon('heroicon-m-pencil-square', position: 'before')
                ->color('warning'),

            // Total Stat
            Stat::make(__('navigation.column.total_pages'), $totalCount)
                ->description(__('navigation.column.visible_on_site'))
                ->descriptionIcon('heroicon-m-document-duplicate', position: 'before')
                ->color('gray'),
        ];
    }
}