<?php

namespace App\Filament\Admin\Resources\AppPanelProviderResource\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;

class ActiveUsersLastMonthStats extends ChartWidget
{
    protected static ?string $heading = 'Active Users in the Last Month';

    protected function getData(): array
    {
        $activeUsersLastMonth = User::whereHas('houses', function ($query) {
            $query->where('created_at', '>=', now()->subDays(30));
        })
            ->orWhere('updated_at', '>=', now()->subDays(30))
            ->distinct()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Active Users',
                    'data' => [$activeUsersLastMonth],
                    'backgroundColor' => ['#3490dc'],
                ],
            ],
            'labels' => ['Active Users (Last 30 Days)'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
