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
        return cache()->remember('dashboard_stats_overview_v2', now()->addMinutes(15), function () {
            return [
                Stat::make('Total Tours', Tour::where('status', 'active')->count())
                    ->description('Active tours in system')
                    ->descriptionIcon('heroicon-m-globe-alt')
                    ->color('success'),
                
                Stat::make('Total Leads', ContactLead::count())
                    ->description('New contact requests')
                    ->descriptionIcon('heroicon-m-envelope')
                    ->color('primary'),

                Stat::make('Total Bookings', Booking::count())
                    ->description('Total bookings')
                    ->descriptionIcon('heroicon-m-ticket')
                    ->color('warning'),

                Stat::make('Total Revenue', '$' . number_format(
                    Booking::where(function ($query) {
                        $query->where('payment_status', 'paid')
                            ->orWhereIn('status', ['paid', 'completed']);
                    })->sum('total_price'), 
                    2
                ))
                    ->description('Confirmed revenue')
                    ->descriptionIcon('heroicon-m-currency-dollar')
                    ->color('success'),
            ];
        });
    }
}
