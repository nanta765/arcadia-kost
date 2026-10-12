<?php

namespace App\Filament\Resources\Bookings;

use App\Filament\Resources\Bookings\Pages\CreateBooking;
use App\Filament\Resources\Bookings\Pages\EditBooking;
use App\Filament\Resources\Bookings\Pages\ListBookings;
use App\Models\Booking;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables;

// Import komponen Form
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\FileUpload; // BARU: Untuk upload resi

// Import komponen Table
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn; // BARU: Untuk nampilin resi
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\BulkActionGroup;

// Import Actions sesuai struktur aslimu
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Schemas\Components\Section as ComponentsSection;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    // Menggunakan Heroicon bawaan
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Bookings';
    protected static ?string $pluralLabel = 'Bookings';

    // Menggunakan id sebagai title attribute untuk pencarian
    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // Menggunakan Section, bukan Select, agar bisa membungkus form lain
                ComponentsSection::make('Detail Pemesanan')->schema([
                    Select::make('user_id')
                        ->relationship('user', 'name')
                        ->disabled()
                        ->label('Nama Anak Kost'),

                    Select::make('room_id')
                        ->relationship('room', 'room_number')
                        ->disabled()
                        ->label('Nomor Kamar'),

                    DatePicker::make('start_date')
                        ->disabled()
                        ->label('Tanggal Masuk'),

                    DatePicker::make('end_date')
                        ->disabled()
                        ->label('Jatuh Tempo'),

                    TextInput::make('total_price')
                        ->numeric()
                        ->prefix('Rp')
                        ->disabled()
                        ->label('Total Bayar'),

                    Select::make('status')
                        ->options([
                            'pending' => 'Menunggu Pembayaran',
                            'review' => 'Menunggu Konfirmasi Resi', // BARU: Status saat user selesai upload
                            'active' => 'Aktif (Sudah Bayar)',
                            'cancelled' => 'Dibatalkan',
                        ])
                        ->required()
                        ->label('Status Pesanan'),

                    // BARU: Penampil foto resi transfer
                    FileUpload::make('proof_of_payment')
                        ->image()
                        ->disk('public')
                        ->directory('proofs')
                        ->label('Foto Resi Bukti Transfer')
                        ->disabled() // Admin hanya melihat, tidak boleh mengganti file milik user
                        ->columnSpanFull(),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Anak Kost')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('room.room_number')
                    ->label('No. Kamar')
                    ->sortable(),

                TextColumn::make('room.roomType.name')
                    ->label('Tipe Kamar'),

                // BARU: Menampilkan foto kecil resi di tabel utama
                ImageColumn::make('proof_of_payment')
                    ->label('Resi Transfer')
                    ->disk('public')
                    ->square(),

                // BARU: Metode pembayaran dari Payment terakhir
                TextColumn::make('payment_method')
                    ->label('Metode Bayar')
                    ->badge()
                    ->getStateUsing(fn(Booking $record): ?string => $record->latestPayment?->payment_method)
                    ->formatStateUsing(fn(?string $state): string => match ($state) {
                        'bank_transfer' => 'Transfer Bank',
                        'on_site' => 'Bayar di Tempat',
                        default => '-',
                    })
                    ->color(fn(?string $state): string => match ($state) {
                        'bank_transfer' => 'info',
                        'on_site' => 'gray',
                        default => 'gray',
                    }),

                TextColumn::make('start_date')
                    ->date('d M Y')
                    ->label('Mulai Sewa')
                    ->sortable(),

                TextColumn::make('end_date')
                    ->date('d M Y')
                    ->label('Jatuh Tempo'),

                TextColumn::make('total_price')
                    ->money('IDR', locale: 'id')
                    ->label('Total Tagihan')
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'gray',
                        'review' => 'warning', // Warna oranye jika butuh dicek admin
                        'active' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => 'Belum Bayar',
                        'review' => 'Butuh Konfirmasi', // Teks status baru
                        'active' => 'Aktif',
                        'cancelled' => 'Dibatalkan',
                        default => $state,
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Menunggu Pembayaran',
                        'review' => 'Butuh Konfirmasi', // Tambahan filter
                        'active' => 'Aktif',
                        'cancelled' => 'Dibatalkan',
                    ])
            ])
            ->recordActions([
                // BARU: Setujui pembayaran (hanya saat status 'review')
                Action::make('approve')
                    ->label('Setujui')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn(Booking $record): bool => $record->status === 'review')
                    ->action(function (Booking $record): void {
                        DB::transaction(function () use ($record) {
                            $record->update(['status' => 'active']);

                            if ($record->room) {
                                $record->room->update(['status' => 'occupied']);
                            }

                            $payment = $record->payments()->latest()->first();
                            if ($payment) {
                                $payment->update([
                                    'status' => 'success',
                                    'verified_at' => now(),
                                ]);
                            }
                        });

                        Notification::make()
                            ->success()
                            ->title('Pembayaran disetujui')
                            ->send();
                    }),

                // BARU: Tolak pembayaran (hanya saat status 'review')
                Action::make('reject')
                    ->label('Tolak')
                    ->icon(Heroicon::OutlinedXCircle)
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn(Booking $record): bool => $record->status === 'review')
                    ->schema([
                        Textarea::make('reason')
                            ->label('Alasan Penolakan')
                            ->nullable(),
                    ])
                    ->action(function (Booking $record, array $data): void {
                        DB::transaction(function () use ($record, $data) {
                            $record->update(['status' => 'pending']);

                            $payment = $record->payments()->latest()->first();
                            if ($payment) {
                                $payment->update([
                                    'status' => 'failed',
                                    'notes' => $data['reason'] ?? null,
                                ]);
                            }
                        });

                        Notification::make()
                            ->warning()
                            ->title('Pembayaran ditolak')
                            ->send();
                    }),

                EditAction::make()
                    ->label('Ubah Status'),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBookings::route('/'),
            'create' => CreateBooking::route('/create'),
            'edit' => EditBooking::route('/{record}/edit'),
        ];
    }
}
