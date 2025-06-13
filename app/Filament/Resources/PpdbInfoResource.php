<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PpdbInfoResource\Pages;
use App\Models\PpdbInfo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PpdbInfoResource extends Resource
{
    protected static ?string $model = PpdbInfo::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'PPDB Info';
    protected static ?string $modelLabel = 'Informasi PPDB';
    protected static ?string $pluralModelLabel = 'Informasi PPDB';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('judul')
                ->label('Judul')
                ->required()
                ->maxLength(255),
            Forms\Components\Select::make('kategori')
                ->label('Kategori')
                ->options([
                    'syarat' => 'Syarat Pendaftaran',
                    'gelombang' => 'Gelombang Pendaftaran',
                    'jadwal' => 'Jadwal',
                    'biaya' => 'Biaya',
                    'seragam' => 'Seragam',
                    'spp' => 'SPP',
                ])
                ->required()
                ->reactive()
                ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('konten', [])),
            Forms\Components\TextInput::make('urutan')
                ->label('Urutan')
                ->numeric()
                ->default(0)
                ->required(),
            Forms\Components\Toggle::make('is_active')
                ->label('Status Aktif')
                ->default(true),
            Forms\Components\Grid::make()
                ->schema(fn (Forms\Get $get) => match ($get('kategori')) {
                    'spp' => [
                        Forms\Components\TextInput::make('konten.spp')
                            ->label('SPP')
                            ->numeric()
                            ->required()
                            ->default(0),
                        Forms\Components\TextInput::make('konten.makan')
                            ->label('Uang Makan')
                            ->numeric()
                            ->required()
                            ->default(0),
                        Forms\Components\TextInput::make('konten.ekstrakurikuler')
                            ->label('Ekstrakurikuler')
                            ->numeric()
                            ->required()
                            ->default(0),
                    ],
                    default => [
                        Forms\Components\KeyValue::make('konten')
                            ->label('Konten')
                            ->keyLabel('Nama Item')
                            ->valueLabel('Nilai')
                            ->addButtonLabel('Tambah Item')
                    ],
                }),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kategori')
                    ->label('Kategori')
                    ->formatStateUsing(fn ($state) => ucwords(str_replace('_', ' ', $state)))
                    ->sortable(),
                Tables\Columns\TextColumn::make('urutan')
                    ->label('Urutan')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->label('Kategori')
                    ->options([
                        'syarat' => 'Syarat Pendaftaran',
                        'gelombang' => 'Gelombang Pendaftaran',
                        'jadwal' => 'Jadwal',
                        'biaya' => 'Biaya',
                        'seragam' => 'Seragam',
                        'spp' => 'SPP',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('urutan', 'asc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPpdbInfos::route('/'),
            'create' => Pages\CreatePpdbInfo::route('/create'),
            'edit' => Pages\EditPpdbInfo::route('/{record}/edit'),
        ];
    }
}