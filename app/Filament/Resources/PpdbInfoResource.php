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
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Dasar')
                    ->schema([
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
                            ->live()
                            ->default('syarat')
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                // Set default konten berdasarkan kategori
                                $defaultKonten = match($state) {
                                    'syarat' => ['syarat_1' => '', 'syarat_2' => '', 'syarat_3' => '', 'syarat_4' => '', 'syarat_5' => '', 'syarat_6' => '', 'syarat_7' => '', 'syarat_8' => ''],
                                    'gelombang' => ['periode' => '', 'kuota' => '', 'diskon' => '', 'status' => ''],
                                    'jadwal' => ['senin_jumat' => '', 'sabtu' => '', 'minggu' => ''],
                                    'biaya' => ['pendaftaran' => 0, 'seragam' => 0, 'buku' => 0, 'kegiatan' => 0, 'total' => 0],
                                    'seragam' => [],
                                    'spp' => ['spp' => 0, 'makan' => 0, 'ekstrakurikuler' => 0, 'total' => 0],
                                    default => [],
                                };
                                $set('konten', $defaultKonten);
                            }),

                        Forms\Components\TextInput::make('urutan')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0)
                            ->required(),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true),
                    ]),

                Forms\Components\Hidden::make('konten')
                    ->default(['syarat_1' => '', 'syarat_2' => '', 'syarat_3' => '', 'syarat_4' => '', 'syarat_5' => '', 'syarat_6' => '', 'syarat_7' => '', 'syarat_8' => '']),

                Forms\Components\Section::make('Daftar Syarat')
                    ->schema([
                        Forms\Components\TextInput::make('konten.syarat_1')
                            ->label('Syarat 1')
                            ->required()
                            ->placeholder('Masukkan syarat pendaftaran')
                            ->helperText('Contoh: Fotokopi KK'),

                        Forms\Components\TextInput::make('konten.syarat_2')
                            ->label('Syarat 2')
                            ->placeholder('Masukkan syarat pendaftaran')
                            ->helperText('Contoh: Fotokopi Akte Kelahiran'),

                        Forms\Components\TextInput::make('konten.syarat_3')
                            ->label('Syarat 3')
                            ->placeholder('Masukkan syarat pendaftaran')
                            ->helperText('Contoh: Pas Foto 3x4'),

                        Forms\Components\TextInput::make('konten.syarat_4')
                            ->label('Syarat 4')
                            ->placeholder('Masukkan syarat pendaftaran')
                            ->helperText('Contoh: Ijazah/SKL'),

                        Forms\Components\TextInput::make('konten.syarat_5')
                            ->label('Syarat 5')
                            ->placeholder('Masukkan syarat pendaftaran')
                            ->helperText('Contoh: SKHUN'),

                        Forms\Components\TextInput::make('konten.syarat_6')
                            ->label('Syarat 6')
                            ->placeholder('Masukkan syarat pendaftaran')
                            ->helperText('Contoh: Surat Keterangan Sehat'),

                        Forms\Components\TextInput::make('konten.syarat_7')
                            ->label('Syarat 7')
                            ->placeholder('Masukkan syarat pendaftaran')
                            ->helperText('Contoh: Kartu Keluarga'),

                        Forms\Components\TextInput::make('konten.syarat_8')
                            ->label('Syarat 8')
                            ->placeholder('Masukkan syarat pendaftaran')
                            ->helperText('Contoh: Piagam (jika ada)'),
                    ])
                    ->collapsible()
                    ->visible(fn (Forms\Get $get) => $get('kategori') === 'syarat'),

                Forms\Components\Section::make('Konten')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('konten.periode')
                                    ->label('Periode')
                                    ->required()
                                    ->placeholder('Contoh: Gelombang 1 (Januari - Maret 2024)')
                                    ->helperText('Masukkan periode gelombang pendaftaran')
                                    ->columnSpanFull()
                                    ->afterStateHydrated(function ($component, $state) {
                                        if (is_array($state)) {
                                            $component->state($state['periode'] ?? '');
                                        }
                                    })
                                    ->visible(fn (Forms\Get $get) => $get('kategori') === 'gelombang'),

                                Forms\Components\TextInput::make('konten.kuota')
                                    ->label('Kuota')
                                    ->required()
                                    ->numeric()
                                    ->placeholder('Contoh: 50')
                                    ->helperText('Masukkan jumlah kuota yang tersedia')
                                    ->afterStateHydrated(function ($component, $state) {
                                        if (is_array($state)) {
                                            $component->state($state['kuota'] ?? '');
                                        }
                                    })
                                    ->visible(fn (Forms\Get $get) => $get('kategori') === 'gelombang'),

                                Forms\Components\TextInput::make('konten.diskon')
                                    ->label('Diskon')
                                    ->required()
                                    ->numeric()
                                    ->suffix('%')
                                    ->placeholder('Contoh: 10')
                                    ->helperText('Masukkan persentase diskon yang diberikan')
                                    ->afterStateHydrated(function ($component, $state) {
                                        if (is_array($state)) {
                                            $component->state($state['diskon'] ?? '');
                                        }
                                    })
                                    ->visible(fn (Forms\Get $get) => $get('kategori') === 'gelombang'),

                                Forms\Components\Select::make('konten.status')
                                    ->label('Status')
                                    ->options([
                                        'Aktif' => 'Aktif',
                                        'Berakhir' => 'Berakhir',
                                        'Akan Datang' => 'Akan Datang',
                                    ])
                                    ->required()
                                    ->placeholder('Pilih status')
                                    ->helperText('Pilih status gelombang pendaftaran')
                                    ->afterStateHydrated(function ($component, $state) {
                                        if (is_array($state)) {
                                            $component->state($state['status'] ?? '');
                                        }
                                    })
                                    ->visible(fn (Forms\Get $get) => $get('kategori') === 'gelombang'),
                            ]),

                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('konten.senin_jumat')
                                    ->label('Senin - Jumat')
                                    ->required()
                                    ->visible(fn (Forms\Get $get) => $get('kategori') === 'jadwal'),

                                Forms\Components\TextInput::make('konten.sabtu')
                                    ->label('Sabtu')
                                    ->required()
                                    ->visible(fn (Forms\Get $get) => $get('kategori') === 'jadwal'),

                                Forms\Components\TextInput::make('konten.minggu')
                                    ->label('Minggu')
                                    ->required()
                                    ->visible(fn (Forms\Get $get) => $get('kategori') === 'jadwal'),
                            ]),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('konten.pendaftaran')
                                    ->label('Biaya Pendaftaran')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rp ')
                                    ->helperText('Masukkan biaya pendaftaran dalam rupiah')
                                    ->live()
                                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                        static::updateTotal($set, $get);
                                    })
                                    ->visible(fn (Forms\Get $get) => $get('kategori') === 'biaya'),

                                Forms\Components\TextInput::make('konten.seragam')
                                    ->label('Biaya Seragam')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rp ')
                                    ->helperText('Masukkan biaya seragam dalam rupiah')
                                    ->live()
                                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                        static::updateTotal($set, $get);
                                    })
                                    ->visible(fn (Forms\Get $get) => $get('kategori') === 'biaya'),

                                Forms\Components\TextInput::make('konten.buku')
                                    ->label('Biaya Buku')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rp ')
                                    ->helperText('Masukkan biaya buku dalam rupiah')
                                    ->live()
                                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                        static::updateTotal($set, $get);
                                    })
                                    ->visible(fn (Forms\Get $get) => $get('kategori') === 'biaya'),

                                Forms\Components\TextInput::make('konten.kegiatan')
                                    ->label('Biaya Kegiatan')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rp ')
                                    ->helperText('Masukkan biaya kegiatan dalam rupiah')
                                    ->live()
                                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                        static::updateTotal($set, $get);
                                    })
                                    ->visible(fn (Forms\Get $get) => $get('kategori') === 'biaya'),

                                Forms\Components\TextInput::make('konten.total')
                                    ->label('Total')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rp ')
                                    ->disabled()
                                    ->dehydrated()
                                    ->helperText('Total semua biaya (otomatis)')
                                    ->visible(fn (Forms\Get $get) => $get('kategori') === 'biaya'),
                            ]),

                        Forms\Components\Repeater::make('konten_seragam')
                            ->label('Daftar Seragam')
                            ->schema([
                                Forms\Components\TextInput::make('nama')
                                    ->label('Nama Seragam')
                                    ->required(),
                                Forms\Components\TextInput::make('jumlah')
                                    ->label('Jumlah')
                                    ->required(),
                                Forms\Components\TextInput::make('harga')
                                    ->label('Harga')
                                    ->required(),
                            ])
                            ->defaultItems(1)
                            ->minItems(1)
                            ->visible(fn (Forms\Get $get) => $get('kategori') === 'seragam'),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('konten.spp')
                                    ->label('SPP')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rp ')
                                    ->helperText('Biaya SPP per bulan')
                                    ->live()
                                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                        static::updateTotalSpp($set, $get);
                                    })
                                    ->visible(fn (Forms\Get $get) => $get('kategori') === 'spp'),

                                Forms\Components\TextInput::make('konten.makan')
                                    ->label('Uang Makan')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rp ')
                                    ->helperText('Biaya uang makan per bulan')
                                    ->live()
                                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                        static::updateTotalSpp($set, $get);
                                    })
                                    ->visible(fn (Forms\Get $get) => $get('kategori') === 'spp'),

                                Forms\Components\TextInput::make('konten.ekstrakurikuler')
                                    ->label('Ekstrakurikuler')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rp ')
                                    ->helperText('Biaya ekstrakurikuler per bulan')
                                    ->live()
                                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                        static::updateTotalSpp($set, $get);
                                    })
                                    ->visible(fn (Forms\Get $get) => $get('kategori') === 'spp'),

                                Forms\Components\TextInput::make('konten.total')
                                    ->label('Total')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rp ')
                                    ->disabled()
                                    ->dehydrated()
                                    ->helperText('Total biaya per bulan (otomatis)')
                                    ->visible(fn (Forms\Get $get) => $get('kategori') === 'spp'),
                            ]),
                    ]),
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
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'syarat' => 'Syarat Pendaftaran',
                        'gelombang' => 'Gelombang Pendaftaran',
                        'jadwal' => 'Jadwal',
                        'biaya' => 'Biaya',
                        'seragam' => 'Seragam',
                        'spp' => 'SPP',
                    })
                    ->searchable()
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
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPpdbInfos::route('/'),
            'create' => Pages\CreatePpdbInfo::route('/create'),
            'edit' => Pages\EditPpdbInfo::route('/{record}/edit'),
        ];
    }

    protected static function updateTotal(Forms\Set $set, Forms\Get $get): void
    {
        $pendaftaran = (int) $get('konten.pendaftaran') ?? 0;
        $seragam = (int) $get('konten.seragam') ?? 0;
        $buku = (int) $get('konten.buku') ?? 0;
        $kegiatan = (int) $get('konten.kegiatan') ?? 0;

        $total = $pendaftaran + $seragam + $buku + $kegiatan;
        $set('konten.total', $total);
    }

    protected static function updateTotalSpp(Forms\Set $set, Forms\Get $get): void
    {
        $spp = (int) $get('konten.spp') ?? 0;
        $makan = (int) $get('konten.makan') ?? 0;
        $ekstrakurikuler = (int) $get('konten.ekstrakurikuler') ?? 0;

        $total = $spp + $makan + $ekstrakurikuler;
        $set('konten.total', $total);
    }
} 