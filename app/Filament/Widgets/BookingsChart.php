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
        $data = Booking::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as aggregate')
            ->where('created_at', '>=', now()->subYear())
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Bookings',
                    'data' => $data->map(fn ($row) => $row->aggregate)->toArray(),
                    'borderColor' => '#f59e0b', // Amber
                ],
            ],
            'labels' => $data->map(fn ($row) => Carbon::createFromFormat('Y-m', $row->month)->format('M Y'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
