<?php

namespace App\Filament\Widgets;

use App\Models\Staff;
use App\Models\StaffCategory;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StaffStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        // 1. Total Active Staff
        $activeStaffCount = Staff::where('is_active', true)->count();

        // 2. Breakdown by Category (Only counting active staff)
        $categories = StaffCategory::withCount(['staff' => function ($query) {
            $query->where('is_active', true);
        }])->get();

        $stats = [
            // Main Stat: Total Active
            Stat::make(__('navigation.resources.staff'), $activeStaffCount)
                ->icon('heroicon-m-users') // Icons at the top start
                ->description(__('navigation.form.is_active')) // Using key from your file
                ->color('success'),
        ];

        // 3. Dynamic Stats for each category
        foreach ($categories as $category) {
            $stats[] = Stat::make(
                $category->getTranslation('name', app()->getLocale()), 
                $category->staff_count
            )
            ->icon('heroicon-m-tag') // Icons at the top start
            ->description(__('navigation.column.total_by_category'))
            ->color('primary');
        }

        return $stats;
    }
}