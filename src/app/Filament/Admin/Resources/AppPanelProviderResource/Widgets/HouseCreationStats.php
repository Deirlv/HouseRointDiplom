<?php

namespace App\Filament\Admin\Resources\AppPanelProviderResource\Widgets;

use App\Models\House;
use Filament\Widgets\ChartWidget;

class HouseCreationStats extends ChartWidget
{
    protected static ?string $heading = 'House Creation Statistics';

    protected function getData(): array
    {
        $housesThisMonth = House::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $housesThisYear = House::whereYear('created_at', now()->year)->count();

        return [
            'datasets' => [
                [
                    'label' => 'Houses Created',
                    'data' => [$housesThisMonth, $housesThisYear],
                    'backgroundColor' => ['#65b32e', '#ff9f40'],
                ],
            ],
            'labels' => ['This Month', 'This Year'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
