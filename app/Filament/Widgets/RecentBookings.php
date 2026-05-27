<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Filament\Tables\Columns\TextColumn;

class RecentBookings extends TableWidget
{
    protected int|string|array $columnSpan = 'full';
    protected static ?string $heading = 'Recent Bookings';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Booking::query()->latest()
            )

            ->columns([
                TextColumn::make('user.name')
                    ->searchable(),

                TextColumn::make('room.room_number')
                    ->label('Room Number'),

                TextColumn::make('status')
                    ->badge(),

                TextColumn::make('total_price')
                    ->money('IDR'),
            ]);
    }
}
