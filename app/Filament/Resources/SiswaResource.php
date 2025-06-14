<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiswaResource\Pages;
use App\Filament\Resources\SiswaResource\RelationManagers;
use App\Models\Siswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SiswaResource extends Resource
{
    protected static ?string $model = Siswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Siswa';
    protected static ?string $modelLabel = 'Data Siswa';
    protected static ?string $pluralModelLabel = 'Data Siswa';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Siswa')
                    ->schema([
                        Forms\Components\TextInput::make('nis')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(20),
                        Forms\Components\TextInput::make('nisn')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(20),
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('jenis_kelamin')
                            ->options([
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('tempat_lahir')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\DatePicker::make('tanggal_lahir')
                            ->required()
                            ->maxDate(now()),
                        Forms\Components\Select::make('agama')
                            ->options([
                                'Islam' => 'Islam',
                                'Kristen' => 'Kristen',
                                'Katolik' => 'Katolik',
                                'Hindu' => 'Hindu',
                                'Buddha' => 'Buddha',
                                'Konghucu' => 'Konghucu',
                            ])
                            ->required(),
                        Forms\Components\Textarea::make('alamat')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('no_hp')
                            ->tel()
                            ->required()
                            ->maxLength(15),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->nullable(),
                        Forms\Components\FileUpload::make('foto')
                            ->image()
                            ->directory('public/siswa')
                            ->nullable(),
                        Forms\Components\Select::make('id_jurusan')
                            ->label('Jurusan')
                            ->relationship('jurusan', 'nama_jurusan')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('kode_jurusan')
                                    ->required()
                                    ->unique()
                                    ->maxLength(10),
                                Forms\Components\TextInput::make('nama_jurusan')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('deskripsi')
                                    ->nullable(),
                                Forms\Components\TextInput::make('kepala_jurusan')
                                    ->nullable(),
                                Forms\Components\Select::make('status')
                                    ->options([
                                        'Aktif' => 'Aktif',
                                        'Tidak Aktif' => 'Tidak Aktif',
                                    ])
                                    ->default('Aktif')
                                    ->required(),
                            ])
                            ->live(),
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
                Tables\Columns\ImageColumn::make('foto')
                    ->circular(),
                Tables\Columns\TextColumn::make('nis')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nisn')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'L' => 'primary',
                        'P' => 'success',
                    }),
                Tables\Columns\TextColumn::make('jurusan.nama_jurusan')
                    ->label('Jurusan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Aktif' => 'success',
                        'Tidak Aktif' => 'danger',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Aktif' => 'Aktif',
                        'Tidak Aktif' => 'Tidak Aktif',
                    ]),
                Tables\Filters\SelectFilter::make('jenis_kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ]),
                Tables\Filters\SelectFilter::make('jurusan')
                    ->relationship('jurusan', 'nama_jurusan'),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListSiswas::route('/'),
            'create' => Pages\CreateSiswa::route('/create'),
            'edit' => Pages\EditSiswa::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->can('view_siswas');
    }
    
    public static function canCreate(): bool
    {
        return auth()->user()?->can('create_siswas');
    }

    public static function canEdit(
        $record
    ): bool {
        return auth()->user()?->can('edit_siswas');
    }

    public static function canDelete(
        $record
    ): bool {
        return auth()->user()?->can('delete_siswas');
    }
}