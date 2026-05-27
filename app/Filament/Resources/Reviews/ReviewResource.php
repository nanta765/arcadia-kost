<?php

namespace App\Filament\Resources\Reviews;

use App\Filament\Resources\Reviews\Pages;
use App\Models\Review;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

// Import Form Components
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

// Import Table Components
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;

// Import Actions sesuai struktur yang terbukti berhasil
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Schemas\Components\Section as ComponentsSection;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedStar;

    protected static ?string $navigationLabel = 'Reviews';
    protected static ?string $pluralLabel = 'Reviews';
    
    // Memastikan URL selalu konsisten
    protected static ?string $slug = 'reviews';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                ComponentsSection::make('Detail Ulasan Anak Kost')->schema([
                    Select::make('user_id')
                        ->relationship('user', 'name')
                        ->label('Pengirim')
                        ->disabled(),

                    Select::make('room_id')
                        ->relationship('room', 'room_number')
                        ->label('Kamar yang Diulas')
                        ->disabled(),

                    TextInput::make('rating')
                        ->numeric()
                        ->label('Bintang (1-5)')
                        ->disabled(),

                    Textarea::make('comment')
                        ->label('Komentar')
                        ->columnSpanFull()
                        ->disabled(),

                    Toggle::make('is_visible')
                        ->label('Tampilkan di Landing Page')
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

                TextColumn::make('rating')
                    ->label('Rating')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        '5', '4' => 'success',
                        '3' => 'warning',
                        '2', '1' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => $state . ' ⭐')
                    ->sortable(),

                TextColumn::make('comment')
                    ->label('Komentar')
                    ->limit(40)
                    ->searchable(),

                ToggleColumn::make('is_visible')
                    ->label('Tampil')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->date('d M Y')
                    ->label('Tanggal')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()->label('Lihat Detail'),
                DeleteAction::make()->label('Hapus'),
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
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'view' => Pages\ViewReview::route('/{record}'), 
        ];
    }
}