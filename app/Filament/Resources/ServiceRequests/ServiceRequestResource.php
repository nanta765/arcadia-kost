<?php

namespace App\Filament\Resources\ServiceRequests;

use App\Filament\Resources\ServiceRequests\Pages\CreateServiceRequest;
use App\Filament\Resources\ServiceRequests\Pages\EditServiceRequest;
use App\Filament\Resources\ServiceRequests\Pages\ListServiceRequests;
use App\Filament\Resources\ServiceRequests\Schemas\ServiceRequestForm;
use App\Filament\Resources\ServiceRequests\Tables\ServiceRequestsTable;
use App\Models\ServiceRequest;
use BackedEnum;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\BulkActionGroup;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction as ActionsEditAction;

class ServiceRequestResource extends Resource
{
    protected static ?string $model = ServiceRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        $isOwner = Auth::user()?->role === 'owner';

        return $schema
            ->schema([
                TextInput::make('room.room_number')->label('No. Kamar')->disabled(),
                TextInput::make('user.name')->label('Nama Anak Kost')->disabled(),
                TextInput::make('type')
                    ->label('Jenis Permintaan')
                    ->formatStateUsing(fn($state) => $state === 'cleaning' ? 'Bersihkan Kamar' : 'Perbaikan')
                    ->disabled(),
                Textarea::make('notes')->label('Catatan dari Penghuni')->disabled()->columnSpanFull(),

                TextInput::make('deadline')
                    ->label('Tenggat Waktu')
                    ->disabled(),

                Select::make('status')
                    ->options([
                        'pending' => 'Menunggu',
                        'completed' => 'Selesai',
                    ])
                    ->required()
                    ->label('Status Pengerjaan')
                    ->disabled($isOwner),

                DateTimePicker::make('completed_at')
                    ->label('Waktu Selesai')
                    ->disabled()
                    ->visible(fn($record) => $record && $record->status === 'completed'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('room.room_number')
                    ->label('Kamar')
                    ->sortable(), // <-- Ubah titik menjadi panah di sini

                TextColumn::make('user.name')
                    ->label('Penghuni')
                    ->searchable(), // <-- Ubah titik menjadi panah di sini

                TextColumn::make('type')
                    ->label('Layanan')
                    ->formatStateUsing(fn($state) => $state === 'cleaning' ? 'Bersihkan' : 'Perbaikan'),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'completed' => 'success',
                    }),

                TextColumn::make('deadline')
                    ->label('Tenggat')
                    ->placeholder('-'),

                TextColumn::make('created_at')
                    ->label('Waktu Permintaan')
                    ->dateTime('H:i - d M Y'),

                TextColumn::make('completed_at')
                    ->label('Selesai')
                    ->dateTime('d M Y, H:i')
                    ->placeholder('-'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionsEditAction::make()->label('Update Status'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
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
            'index' => ListServiceRequests::route('/'),
            'create' => CreateServiceRequest::route('/create'),
            'edit' => EditServiceRequest::route('/{record}/edit'),
        ];
    }
}
