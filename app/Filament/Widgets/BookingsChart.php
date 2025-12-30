<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class BookingsChart extends ChartWidget
{
    protected ?string $heading = 'Bookings Over Time';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = Booking::selectRaw('DATE(created_at) as date, COUNT(*) as aggregate')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupByRaw('DATE(created_at)')
            ->orderBy('date')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Daily Bookings',
                    'data' => $data->map(fn ($row) => $row->aggregate)->toArray(),
                    'backgroundColor' => 'rgba(245, 158, 11, 0.8)', // Amber with opacity
                    'borderColor' => '#f59e0b',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $data->map(fn ($row) => Carbon::parse($row->date)->format('d M'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
