<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PpdbResource\Pages;
use App\Models\Ppdb;
use App\Models\Jurusan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PpdbResource extends Resource
{
    protected static ?string $model = Ppdb::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?string $navigationLabel = 'PPDB Siswa Baru';
    protected static ?string $modelLabel = 'Pendaftar PPDB';
    protected static ?string $pluralModelLabel = 'Pendaftar PPDB';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nomor_registrasi')->label('Nomor Registrasi')->disabled(),
            Forms\Components\TextInput::make('nama_lengkap')->required(),
            Forms\Components\TextInput::make('nisn')->required(),
            Forms\Components\TextInput::make('nik')->required(),
            Forms\Components\Select::make('jenis_kelamin')->options([
                'L' => 'Laki-laki',
                'P' => 'Perempuan',
            ])->required(),
            Forms\Components\TextInput::make('tempat_lahir')->required(),
            Forms\Components\DatePicker::make('tanggal_lahir')->required(),
            Forms\Components\TextInput::make('agama')->required(),
            Forms\Components\Textarea::make('alamat')->required(),
            Forms\Components\TextInput::make('kode_pos'),
            Forms\Components\TextInput::make('telepon'),
            Forms\Components\TextInput::make('email')->email(),
            Forms\Components\TextInput::make('nama_ayah')->required(),
            Forms\Components\TextInput::make('pekerjaan_ayah'),
            Forms\Components\TextInput::make('telepon_ayah'),
            Forms\Components\TextInput::make('nama_ibu')->required(),
            Forms\Components\TextInput::make('pekerjaan_ibu'),
            Forms\Components\TextInput::make('telepon_ibu'),
            Forms\Components\TextInput::make('sekolah_asal')->required(),
            Forms\Components\Select::make('id_jurusan')
                ->label('Jurusan')
                ->options(Jurusan::where('status', 'Aktif')->pluck('nama_jurusan', 'id_jurusan'))
                ->required(),
            Forms\Components\Select::make('gelombang')->options([
                '1' => '1',
                '2' => '2',
                '3' => '3',
            ])->required(),
            Forms\Components\Select::make('jalur')->options([
                'Reguler' => 'Reguler',
                'Prestasi' => 'Prestasi',
                'Tidak Mampu' => 'Tidak Mampu',
            ])->required(),
            Forms\Components\Textarea::make('prestasi'),
            Forms\Components\Select::make('status')->options([
                'Menunggu' => 'Menunggu',
                'Diterima' => 'Diterima',
                'Ditolak' => 'Ditolak',
                'Cadangan' => 'Cadangan',
            ])->default('Menunggu'),
            Forms\Components\FileUpload::make('foto')->label('Foto')->image()->directory('ppdb')->maxSize(2048),
            Forms\Components\FileUpload::make('ijazah')->label('Ijazah')->directory('ppdb')->maxSize(2048),
            Forms\Components\FileUpload::make('skhun')->label('SKHUN')->directory('ppdb')->maxSize(2048),
            Forms\Components\FileUpload::make('kartu_keluarga')->label('Kartu Keluarga')->directory('ppdb')->maxSize(2048),
            Forms\Components\FileUpload::make('akta_kelahiran')->label('Akta Kelahiran')->directory('ppdb')->maxSize(2048),
            Forms\Components\FileUpload::make('surat_prestasi')->label('Surat Prestasi')->directory('ppdb')->maxSize(2048),
            Forms\Components\FileUpload::make('surat_tidak_mampu')->label('Surat Tidak Mampu')->directory('ppdb')->maxSize(2048),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor_registrasi')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('nama_lengkap')->searchable(),
                Tables\Columns\TextColumn::make('nisn')->searchable(),
                Tables\Columns\TextColumn::make('jurusan.nama_jurusan')->label('Jurusan')->sortable(),
                Tables\Columns\TextColumn::make('gelombang'),
                Tables\Columns\TextColumn::make('jalur'),
                Tables\Columns\BadgeColumn::make('status')->colors([
                    'primary' => 'Menunggu',
                    'success' => 'Diterima',
                    'danger' => 'Ditolak',
                    'info' => 'Cadangan',
                ]),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y')->label('Daftar'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Menunggu' => 'Menunggu',
                        'Diterima' => 'Diterima',
                        'Ditolak' => 'Ditolak',
                        'Cadangan' => 'Cadangan',
                    ]),
                Tables\Filters\SelectFilter::make('gelombang')
                    ->options([
                        '1' => 'Gelombang 1',
                        '2' => 'Gelombang 2',
                        '3' => 'Gelombang 3',
                    ]),
                Tables\Filters\SelectFilter::make('jalur')
                    ->options([
                        'Reguler' => 'Reguler',
                        'Prestasi' => 'Prestasi',
                        'Tidak Mampu' => 'Tidak Mampu',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('konfirmasi')
                    ->label('Konfirmasi')
                    ->icon('heroicon-o-check-circle')
                    ->color('primary')
                    ->button()
                    ->requiresConfirmation()
                    ->form([
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'Diterima' => 'Diterima',
                                'Ditolak' => 'Ditolak',
                                'Cadangan' => 'Cadangan',
                            ])->required(),
                    ])
                    ->action(function ($record, $data) {
                        $record->status = $data['status'];
                        $record->save();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPpdbs::route('/'),
            'create' => Pages\CreatePpdb::route('/create'),
            'edit' => Pages\EditPpdb::route('/{record}/edit'),
        ];
    }
}