<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProjectOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(app()->getLocale() === 'dv' ? 'ޖުމްލަ މަޝްރޫއު' : 'Total Projects', Project::count())
                ->description(app()->getLocale() === 'dv' ? 'ހަމަޖެހިފައިވާ ހުރި' : 'All recorded projects')
                ->descriptionIcon('heroicon-m-cube')
                ->color('primary'),

            Stat::make(app()->getLocale() === 'dv' ? 'ހިނގަމުންދާ މަޝްރޫއު' : 'Ongoing Projects', Project::where('status', 'ongoing')->count())
                ->description(app()->getLocale() === 'dv' ? 'މިހާރު ކުރިއަށްދާ' : 'Currently active')
                ->color('warning'),

            Stat::make(app()->getLocale() === 'dv' ? 'ޖުމްލަ އަގު' : 'Total Investment', 'MVR ' . number_format(Project::sum('project_cost'), 2))
                ->description(app()->getLocale() === 'dv' ? 'ހުރިހާ މަޝްރޫއެއްގެ' : 'Cumulative project cost')
                ->chart([7, 2, 10, 3, 15, 4, 17]) // Example trend line
                ->color('success'),
        ];
    }
}