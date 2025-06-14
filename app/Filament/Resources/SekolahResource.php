<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SekolahResource\Pages;
use App\Filament\Resources\SekolahResource\RelationManagers;
use App\Models\Sekolah;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SekolahResource extends Resource
{
    protected static ?string $model = Sekolah::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationLabel = 'Sekolah';

    protected static ?string $modelLabel = 'Data Sekolah';

    protected static ?string $pluralModelLabel = 'Data Sekolah';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('npsn')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('nama_sekolah')
                    ->required(),
                Forms\Components\Select::make('status_sekolah')
                    ->options([
                        'Negeri' => 'Negeri',
                        'Swasta' => 'Swasta',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('alamat_sekolah'),
                Forms\Components\TextInput::make('email_sekolah')
                    ->email(),
                Forms\Components\TextInput::make('telepon_sekolah'),
                Forms\Components\TextInput::make('website_sekolah'),
                Forms\Components\RichEditor::make('visi'),
                Forms\Components\RichEditor::make('misi'),
                Forms\Components\RichEditor::make('sejarah'),
                Forms\Components\RichEditor::make('sambutan_kepala_sekolah'),
                Forms\Components\FileUpload::make('foto_kepala_sekolah')
                    ->directory('public/foto-kepala-sekolah')
                    ->image()
                    ->imagePreviewHeight('100')
                    ->label('Foto Kepala Sekolah'),
                Forms\Components\Textarea::make('tujuan'),
                Forms\Components\Textarea::make('motto'),
                Forms\Components\TextInput::make('youtube_id'),
                Forms\Components\FileUpload::make('logo_sekolah')
                    ->directory('public/logo-sekolah')
                    ->image()
                    ->imagePreviewHeight('100')
                    ->label('Logo Sekolah'),
                Forms\Components\FileUpload::make('icon_sekolah')
                    ->directory('public/icon-sekolah')
                    ->image()
                    ->imagePreviewHeight('100')
                    ->label('Icon Sekolah'),
                Forms\Components\TextInput::make('akreditasi'),
                Forms\Components\TextInput::make('tahun_berdiri')
                    ->numeric(),
                Forms\Components\TextInput::make('kode_pos'),
                Forms\Components\TextInput::make('facebook_sekolah'),
                Forms\Components\TextInput::make('youtube_sekolah'),
                Forms\Components\TextInput::make('tiktok_sekolah'),
                Forms\Components\TextInput::make('instagram_sekolah'),
                Forms\Components\TextInput::make('whatsapp_sekolah'),
                Forms\Components\TextInput::make('provinsi'),
                Forms\Components\TextInput::make('kabupaten_kota'),
                Forms\Components\TextInput::make('kecamatan'),
                Forms\Components\TextInput::make('desa_kelurahan'),
                Forms\Components\Textarea::make('google_maps')
                    ->columnSpanFull(),
                Forms\Components\Select::make('jenis_sekolah')
                    ->options([
                        'SMA' => 'SMA',
                        'SMK' => 'SMK',
                        'SLB' => 'SLB',
                    ])
                    ->required(),
                Forms\Components\Select::make('status_aktif')
                    ->options([
                        'Aktif' => 'Aktif',
                        'Tidak Aktif' => 'Tidak Aktif',
                    ])
                    ->default('Aktif')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('npsn')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_sekolah')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status_sekolah')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Negeri' => 'success',
                        'Swasta' => 'warning',
                    }),
                Tables\Columns\TextColumn::make('alamat_sekolah'),
                Tables\Columns\TextColumn::make('email_sekolah'),
                Tables\Columns\TextColumn::make('telepon_sekolah'),
                Tables\Columns\TextColumn::make('website_sekolah'),
                Tables\Columns\TextColumn::make('visi'),
                Tables\Columns\TextColumn::make('misi'),
                Tables\Columns\TextColumn::make('sejarah'),
                Tables\Columns\TextColumn::make('sambutan_kepala_sekolah'),
                Tables\Columns\TextColumn::make('foto_kepala_sekolah'),
                Tables\Columns\TextColumn::make('tujuan'),
                Tables\Columns\TextColumn::make('motto'),
                Tables\Columns\TextColumn::make('youtube_id'),
                Tables\Columns\TextColumn::make('logo_sekolah'),
                Tables\Columns\TextColumn::make('icon_sekolah'),
                Tables\Columns\TextColumn::make('akreditasi')
                    ->badge(),
                Tables\Columns\TextColumn::make('tahun_berdiri')
                    ->sortable(),
                Tables\Columns\TextColumn::make('kode_pos'),
                Tables\Columns\TextColumn::make('facebook_sekolah'),
                Tables\Columns\TextColumn::make('youtube_sekolah'),
                Tables\Columns\TextColumn::make('tiktok_sekolah'),
                Tables\Columns\TextColumn::make('instagram_sekolah'),
                Tables\Columns\TextColumn::make('whatsapp_sekolah'),
                Tables\Columns\TextColumn::make('provinsi'),
                Tables\Columns\TextColumn::make('kabupaten_kota'),
                Tables\Columns\TextColumn::make('kecamatan'),
                Tables\Columns\TextColumn::make('desa_kelurahan'),
                Tables\Columns\TextColumn::make('google_maps'),
                Tables\Columns\TextColumn::make('jenis_sekolah')
                    ->badge(),
                Tables\Columns\TextColumn::make('status_aktif')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Aktif' => 'success',
                        'Tidak Aktif' => 'danger',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_sekolah')
                    ->options([
                        'Negeri' => 'Negeri',
                        'Swasta' => 'Swasta',
                    ]),
                Tables\Filters\SelectFilter::make('jenis_sekolah')
                    ->options([
                        'SMA' => 'SMA',
                        'SMK' => 'SMK',
                        'SLB' => 'SLB',
                    ]),
                Tables\Filters\SelectFilter::make('status_aktif')
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
            'index' => Pages\ListSekolahs::route('/'),
            'create' => Pages\CreateSekolah::route('/create'),
            'edit' => Pages\EditSekolah::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->can('view_sekolahs');
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create_sekolahs');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('edit_sekolahs');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete_sekolahs');
    }
}