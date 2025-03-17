<?php

namespace App\Filament\Widgets;

use App\Models\Book;
use App\Models\BookBorrow;
use App\Models\Penalty;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Books', Book::count())
                ->description('Total books in the library')
                ->descriptionIcon('heroicon-m-book-open')
                ->color('primary'),
            Stat::make('Total Users', User::count())
                ->description('Registered users')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
            Stat::make('Active Borrows', BookBorrow::where('status', 'borrowed')->count())
                ->description('Books currently borrowed')
                ->descriptionIcon('heroicon-m-arrow-path-rounded-square')
                ->color('warning'),
            Stat::make('Overdue Books', BookBorrow::where('status', 'borrowed')->where('due_date', '<', now())->count())
                ->description('Books past due date')
                ->descriptionIcon('heroicon-m-clock')
                ->color('danger'),
            Stat::make('Unpaid Penalties', 'Rp ' . number_format(Penalty::where('status', 'unpaid')->sum('amount'), 0, ',', '.'))
                ->description('Total unpaid penalties')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('danger'),
        ];
    }
}
