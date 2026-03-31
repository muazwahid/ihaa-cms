<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class IhaaInfoWidget extends Widget
{
    // In v4, $view must be a protected string (non-static)
    protected string $view = 'filament.widgets.ihaa-info-widget';

    // $sort remains a static ?int
    protected static ?int $sort = -2;

    // v4 strictly enforces int | string | array for columnSpan
    protected int | string | array $columnSpan = 'half';
}