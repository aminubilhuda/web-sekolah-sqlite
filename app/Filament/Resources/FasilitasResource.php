<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FasilitasResource\Pages;
use App\Filament\Resources\FasilitasResource\RelationManagers;
use App\Models\Fasilitas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FasilitasResource extends Resource
{
    protected static ?string $model = Fasilitas::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationLabel = 'Fasilitas';
    protected static ?string $modelLabel = 'Fasilitas';
    protected static ?string $pluralModelLabel = 'Fasilitas';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Fasilitas')
                    ->schema([
                        Forms\Components\TextInput::make('nama_fasilitas')
                            ->required()
                            ->maxLength(255)
                            ->label('Nama Fasilitas'),
                        Forms\Components\Select::make('kategori')
                            ->options([
                                'Ruang Belajar' => 'Ruang Belajar',
                                'Ruang Administrasi' => 'Ruang Administrasi',
                                'Ruang Laboratorium' => 'Ruang Laboratorium',
                                'Ruang Perpustakaan' => 'Ruang Perpustakaan',
                                'Ruang Olahraga' => 'Ruang Olahraga',
                                'Ruang Kesehatan' => 'Ruang Kesehatan',
                                'Ruang Ibadah' => 'Ruang Ibadah',
                                'Ruang Kesenian' => 'Ruang Kesenian',
                                'Ruang Serbaguna' => 'Ruang Serbaguna',
                                'Sanitasi' => 'Sanitasi',
                                'Lainnya' => 'Lainnya',
                            ])
                            ->required()
                            ->label('Kategori'),
                        Forms\Components\TextInput::make('jumlah')
                            ->numeric()
                            ->nullable()
                            ->label('Jumlah'),
                        Forms\Components\Select::make('kondisi')
                            ->options([
                                'Baik' => 'Baik',
                                'Rusak Ringan' => 'Rusak Ringan',
                                'Rusak Sedang' => 'Rusak Sedang',
                                'Rusak Berat' => 'Rusak Berat',
                            ])
                            ->required()
                            ->label('Kondisi'),
                    ])->columns(2),

                Forms\Components\Section::make('Deskripsi')
                    ->schema([
                        Forms\Components\RichEditor::make('deskripsi')
                            ->label('Deskripsi')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Media')
                    ->schema([
                        Forms\Components\FileUpload::make('foto')
                            ->image()
                            ->directory('public/fasilitas')
                            ->label('Foto Fasilitas'),
                    ]),

                Forms\Components\Section::make('Status')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'Aktif' => 'Aktif',
                                'Tidak Aktif' => 'Tidak Aktif',
                            ])
                            ->default('Aktif')
                            ->required()
                            ->label('Status'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sekolah.nama_sekolah')
                    ->searchable()
                    ->sortable()
                    ->label('Sekolah'),
                Tables\Columns\TextColumn::make('nama_fasilitas')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Fasilitas'),
                Tables\Columns\TextColumn::make('kategori')
                    ->searchable()
                    ->sortable()
                    ->label('Kategori'),
                Tables\Columns\TextColumn::make('jumlah')
                    ->numeric()
                    ->sortable()
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('kondisi')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Baik' => 'success',
                        'Rusak Ringan' => 'warning',
                        'Rusak Sedang' => 'danger',
                        'Rusak Berat' => 'danger',
                    })
                    ->label('Kondisi'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Aktif' => 'success',
                        'Tidak Aktif' => 'danger',
                    })
                    ->label('Status'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Terakhir Diperbarui'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->options([
                        'Ruang Belajar' => 'Ruang Belajar',
                        'Ruang Administrasi' => 'Ruang Administrasi',
                        'Ruang Laboratorium' => 'Ruang Laboratorium',
                        'Ruang Perpustakaan' => 'Ruang Perpustakaan',
                        'Ruang Olahraga' => 'Ruang Olahraga',
                        'Ruang Kesehatan' => 'Ruang Kesehatan',
                        'Ruang Ibadah' => 'Ruang Ibadah',
                        'Ruang Kesenian' => 'Ruang Kesenian',
                        'Ruang Serbaguna' => 'Ruang Serbaguna',
                        'Sanitasi' => 'Sanitasi',
                        'Lainnya' => 'Lainnya',
                    ])
                    ->label('Kategori'),
                Tables\Filters\SelectFilter::make('kondisi')
                    ->options([
                        'Baik' => 'Baik',
                        'Rusak Ringan' => 'Rusak Ringan',
                        'Rusak Sedang' => 'Rusak Sedang',
                        'Rusak Berat' => 'Rusak Berat',
                    ])
                    ->label('Kondisi'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Aktif' => 'Aktif',
                        'Tidak Aktif' => 'Tidak Aktif',
                    ])
                    ->label('Status'),
                Tables\Filters\TrashedFilter::make(),
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
            'index' => Pages\ListFasilitas::route('/'),
            'create' => Pages\CreateFasilitas::route('/create'),
            'edit' => Pages\EditFasilitas::route('/{record}/edit'),
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
        return auth()->user()?->can('view_fasilitas');
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create_fasilitas');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('edit_fasilitas');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete_fasilitas');
    }
}
