<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\ContactLead;
use App\Models\Tour;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Tours', Tour::count())
                ->description('Active tours in system')
                ->descriptionIcon('heroicon-m-globe-alt')
                ->color('success'),
            
            Stat::make('Total Leads', ContactLead::count())
                ->description('New contact requests')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('primary'),

            Stat::make('Total Bookings', Booking::count())
                ->description('Confirmed bookings')
                ->descriptionIcon('heroicon-m-ticket')
                ->color('warning'),

            Stat::make('Total Revenue', '$' . number_format(Booking::sum('total_price'), 2))
                ->description('Total earnings')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),
        ];
    }
}
