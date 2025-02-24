<?php

namespace App\Filament\Admin\Resources\AppPanelProviderResource\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;

class UserRegistrationStats extends ChartWidget
{
    protected static ?string $heading = 'User Registration Statistics';

    protected function getData(): array
    {
        $usersThisMonth = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $usersThisYear = User::whereYear('created_at', now()->year)->count();

        return [
            'datasets' => [
                [
                    'label' => 'User Registrations',
                    'data' => [$usersThisMonth, $usersThisYear],
                    'backgroundColor' => ['#3490dc', '#65b32e'],
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
