<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PtkResource\Pages;
use App\Filament\Resources\PtkResource\RelationManagers;
use App\Models\Ptk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PtkResource extends Resource
{
    protected static ?string $model = Ptk::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'PTK';

    protected static ?string $modelLabel = 'Pendidik dan Tenaga Kependidikan';

    protected static ?string $pluralModelLabel = 'Pendidik dan Tenaga Kependidikan';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Pribadi')
                    ->schema([
                        Forms\Components\TextInput::make('nip')
                            ->label('NIP')
                            ->unique(ignoreRecord: true)
                            ->nullable(),
                        Forms\Components\TextInput::make('nuptk')
                            ->label('NUPTK')
                            ->unique(ignoreRecord: true)
                            ->nullable(),
                        Forms\Components\TextInput::make('nik')
                            ->label('NIK')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->length(16),
                        Forms\Components\TextInput::make('nama')
                            ->required(),
                        Forms\Components\Select::make('jenis_kelamin')
                            ->options([
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('tempat_lahir')
                            ->required(),
                        Forms\Components\DatePicker::make('tanggal_lahir')
                            ->required(),
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
                    ])->columns(2),

                Forms\Components\Section::make('Kontak')
                    ->schema([
                        Forms\Components\Textarea::make('alamat')
                            ->required(),
                        Forms\Components\TextInput::make('kode_pos')
                            ->nullable(),
                        Forms\Components\TextInput::make('telepon')
                            ->tel()
                            ->nullable(),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->nullable(),
                    ])->columns(2),

                Forms\Components\Section::make('Data Kepegawaian')
                    ->schema([
                        Forms\Components\Select::make('status_kepegawaian')
                            ->options([
                                'PNS' => 'Pegawai Negeri Sipil',
                                'GTT' => 'Guru Tidak Tetap',
                                'PTT' => 'Pegawai Tidak Tetap',
                            ])
                            ->required(),
                        Forms\Components\Select::make('jenis_ptk')
                            ->options([
                                'Guru' => 'Guru',
                                'Tenaga Administrasi' => 'Tenaga Administrasi',
                                'Tenaga Laboratorium' => 'Tenaga Laboratorium',
                                'Tenaga Perpustakaan' => 'Tenaga Perpustakaan',
                            ])
                            ->required(),
                        Forms\Components\Select::make('tugas_tambahan')
                            ->options([
                                'Kepala Sekolah' => 'Kepala Sekolah',
                                'Wakil Kepala Sekolah' => 'Wakil Kepala Sekolah',
                                'Tidak Ada' => 'Tidak Ada',
                            ])
                            ->default('Tidak Ada'),
                        Forms\Components\Select::make('status_tugas_tambahan')
                            ->options([
                                'Aktif' => 'Aktif',
                                'Tidak Aktif' => 'Tidak Aktif',
                            ])
                            ->default('Tidak Aktif')
                            ->visible(fn (Forms\Get $get) => $get('tugas_tambahan') !== 'Tidak Ada'),
                        Forms\Components\FileUpload::make('foto')
                        ->image()
                        ->directory('public/ptk')
                        ->nullable(),
                        Forms\Components\TextInput::make('kode_wilayah')
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nip')
                    ->label('NIP')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nuptk')
                    ->label('NUPTK')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nik')
                    ->label('NIK')
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
                Tables\Columns\TextColumn::make('status_kepegawaian')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'PNS' => 'success',
                        'GTT' => 'warning',
                        'PTT' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('jenis_ptk')
                    ->badge(),
                Tables\Columns\TextColumn::make('tugas_tambahan')
                    ->badge()
                    ->visible(fn ($record) => $record && $record->tugas_tambahan !== 'Tidak Ada'),
                Tables\Columns\TextColumn::make('status_tugas_tambahan')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Aktif' => 'success',
                        'Tidak Aktif' => 'danger',
                    })
                    ->visible(fn ($record) => $record && $record->tugas_tambahan !== 'Tidak Ada'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telepon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kode_pos')
                    ->label('Kode Pos')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kode_wilayah')
                    ->label('Kode Wilayah')
                    ->searchable(),
                Tables\Columns\TextColumn::make('foto')
                    ->label('Foto')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_kepegawaian')
                    ->options([
                        'PNS' => 'Pegawai Negeri Sipil',
                        'GTT' => 'Guru Tidak Tetap',
                        'PTT' => 'Pegawai Tidak Tetap',
                    ]),
                Tables\Filters\SelectFilter::make('jenis_ptk')
                    ->options([
                        'Guru' => 'Guru',
                        'Tenaga Administrasi' => 'Tenaga Administrasi',
                        'Tenaga Laboratorium' => 'Tenaga Laboratorium',
                        'Tenaga Perpustakaan' => 'Tenaga Perpustakaan',
                    ]),
                Tables\Filters\SelectFilter::make('tugas_tambahan')
                    ->options([
                        'Kepala Sekolah' => 'Kepala Sekolah',
                        'Wakil Kepala Sekolah' => 'Wakil Kepala Sekolah',
                        'Tidak Ada' => 'Tidak Ada',
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
            'index' => Pages\ListPtks::route('/'),
            'create' => Pages\CreatePtk::route('/create'),
            'edit' => Pages\EditPtk::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->can('view_ptks');
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create_ptks');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('edit_ptks');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete_ptks');
    }
}