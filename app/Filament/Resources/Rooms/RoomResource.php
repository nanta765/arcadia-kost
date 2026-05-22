<?php

namespace App\Filament\Resources\Rooms;

use Filament\Forms\Form;
use App\Filament\Resources\Rooms\Pages\CreateRoom;
use App\Filament\Resources\Rooms\Pages\EditRoom;
use App\Filament\Resources\Rooms\Pages\ListRooms;
use App\Filament\Resources\Rooms\Schemas\RoomForm;
use App\Filament\Resources\Rooms\Tables\RoomsTable;
use App\Models\Room;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;


class RoomResource extends Resource
{
    protected static ?string $model = Room::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('room_type_id')
                    ->relationship('roomType', 'name')
                    ->required()
                    ->label('Tipe Kamar'),

                TextInput::make('room_number')
                    ->required()
                    ->label('Nomor Kamar'),
                Select::make('status')
                    ->options([
                        'available' => 'Available',
                        'occupied' => 'Occupied',
                        'maintenance' => 'Maintenance',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // 1. Panggil foto dari tabel tipe kamar (lewat relasi)
                ImageColumn::make('roomType.image')
                    ->label('Foto')
                    ->circular(),

                // 2. Tampilkan nomor fisik kamarnya (kolom asli dari tabel rooms)
                TextColumn::make('room_number')
                    ->label('Nomor Kamar')
                    ->searchable()
                    ->sortable(),

                // 3. Panggil nama tipe kamarnya (lewat relasi)
                TextColumn::make('roomType.name')
                    ->label('Tipe Kamar')
                    ->searchable(),

                // 4. Panggil harga dari tipe kamar (lewat relasi)
                TextColumn::make('roomType.price')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),

                // 5. Status ini milik fisik kamar, jadi tetap pakai kolom aslinya
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'available' => 'success',
                        'occupied' => 'danger',
                        'maintenance' => 'warning',
                        default => 'gray', // Praktik terbaik: tambahkan default untuk mencegah error
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRooms::route('/'),
            'create' => CreateRoom::route('/create'),
            'edit' => EditRoom::route('/{record}/edit'),
        ];
    }
}
