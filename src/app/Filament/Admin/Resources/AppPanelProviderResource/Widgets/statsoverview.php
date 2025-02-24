<?php

namespace App\Filament\Admin\Resources\AppPanelProviderResource\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;

class statsoverview extends ChartWidget
{
    protected static ?string $heading = 'User House Statistics';

    protected function getData(): array
    {
        $totalUsers = User::count();

        $usersWithHouses = User::has('houses')->count();

        $usersWithoutHouses = $totalUsers - $usersWithHouses;

        return [
            'datasets' => [
                [
                    'label' => 'User House Statistics',
                    'data' => [$usersWithHouses, $usersWithoutHouses],
                    'backgroundColor' => ['#3490dc', '#e3342f'],
                ],
            ],
            'labels' => ['Users with Houses', 'Users without Houses'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
