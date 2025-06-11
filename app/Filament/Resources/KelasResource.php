<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KelasResource\Pages;
use App\Filament\Resources\KelasResource\RelationManagers;
use App\Models\Kelas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KelasResource extends Resource
{
    protected static ?string $model = Kelas::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Kelas';

    protected static ?string $modelLabel = 'Data Kelas';

    protected static ?string $pluralModelLabel = 'Data Kelas';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Kelas')
                    ->schema([
                        Forms\Components\TextInput::make('nama_kelas')
                            ->required(),
                        Forms\Components\TextInput::make('kode_kelas')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Forms\Components\Select::make('id_jurusan')
                            ->relationship('jurusan', 'nama_jurusan')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('id_wali_kelas')
                            ->relationship('waliKelas', 'nama')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        Forms\Components\TextInput::make('kapasitas')
                            ->numeric()
                            ->default(36)
                            ->required(),
                        Forms\Components\TextInput::make('jumlah_siswa')
                            ->numeric()
                            ->default(0),
                        Forms\Components\Select::make('tingkat')
                            ->options([
                                'X' => 'X',
                                'XI' => 'XI',
                                'XII' => 'XII',
                            ])
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'Aktif' => 'Aktif',
                                'Tidak Aktif' => 'Tidak Aktif',
                            ])
                            ->default('Aktif')
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_kelas')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kode_kelas')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jurusan.nama_jurusan')
                    ->label('Jurusan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('waliKelas.nama')
                    ->label('Wali Kelas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kapasitas')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah_siswa')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tingkat')
                    ->badge(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Aktif' => 'success',
                        'Tidak Aktif' => 'danger',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tingkat')
                    ->options([
                        'X' => 'X',
                        'XI' => 'XI',
                        'XII' => 'XII',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Aktif' => 'Aktif',
                        'Tidak Aktif' => 'Tidak Aktif',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListKelas::route('/'),
            'create' => Pages\CreateKelas::route('/create'),
            'edit' => Pages\EditKelas::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->can('view_kelas');
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create_kelas');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('edit_kelas');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete_kelas');
    }
}