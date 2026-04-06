<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;
use Illuminate\Support\Facades\DB;

class ProjectStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        // 1. Ongoing Projects Count
        $ongoingCount = Project::where('status', 'ongoing')->count();

        // 2. Completed Projects Count
        $completedCount = Project::where('status', 'completed')->count();

        // 3. Average Progress (Calculated only for non-completed projects)
        $averageProgress = Project::where('status', '!=', 'completed')
            ->avg('progress_percentage') ?? 0;

        // 4. Total of all projects
        $totalProjects = Project::count();
        // Total Project cost (of all)
        $totalCost = Project::sum('project_cost');

        return [
            // STAT 1: Ongoing Projects & Progress
            Stat::make(__('navigation.column.ongoing_projects'), $ongoingCount)
                ->description(round($averageProgress) . '% ' . __('navigation.column.average_progress'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 10, 12, 18, 20, 25])
                ->color('primary'),

            // STAT 2: Completed Projects
            Stat::make(__('navigation.column.completed_projects'), $completedCount)
                ->description(__('navigation.column.successfully_finished'))
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            // STAT 3: Total Projects
            Stat::make(__('navigation.column.total_projects'), $totalProjects)
                ->description(__('navigation.column.all_time_records'))
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('gray'),
            Stat::make(__('navigation.column.total_projects_cost'), $totalCost)
            ->description(__('navigation.column.total_budget_allocated'))
            ->descriptionIcon('heroicon-m-banknotes')
            ->color('success'),
        ];
    }
}