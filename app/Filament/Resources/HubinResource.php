<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HubinResource\Pages;
use App\Filament\Resources\HubinResource\RelationManagers;
use App\Models\Hubin;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HubinResource extends Resource
{
    protected static ?string $model = Hubin::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationLabel = 'Hubungan Industri';
    protected static ?string $modelLabel = 'Data Hubungan Industri';
    protected static ?string $pluralModelLabel = 'Data Hubungan Industri';
    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Perusahaan')
                    ->schema([
                        Forms\Components\TextInput::make('nama_perusahaan')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('bidang_usaha')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('alamat')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('telepon')
                            ->tel()
                            ->maxLength(15)
                            ->nullable(),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255)
                            ->nullable(),
                        Forms\Components\TextInput::make('website')
                            ->url()
                            ->maxLength(255)
                            ->nullable(),
                    ])->columns(2),

                Forms\Components\Section::make('Data PIC')
                    ->schema([
                        Forms\Components\TextInput::make('nama_pic')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('jabatan_pic')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('telepon_pic')
                            ->tel()
                            ->maxLength(15)
                            ->nullable(),
                        Forms\Components\TextInput::make('email_pic')
                            ->email()
                            ->maxLength(255)
                            ->nullable(),
                    ])->columns(2),

                Forms\Components\Section::make('Data Tambahan')
                    ->schema([
                        Forms\Components\FileUpload::make('logo')
                            ->image()
                            ->directory('public/hubin/logo')
                            ->nullable(),
                        Forms\Components\Textarea::make('deskripsi')
                            ->nullable()
                            ->columnSpanFull(),
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
                Tables\Columns\TextColumn::make('nama_perusahaan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bidang_usaha')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_pic')
                    ->searchable()
                    ->label('PIC'),
                Tables\Columns\TextColumn::make('jabatan_pic')
                    ->searchable()
                    ->label('Jabatan PIC'),
                Tables\Columns\TextColumn::make('sekolah.nama_sekolah')
                    ->searchable()
                    ->sortable()
                    ->label('Sekolah'),
                Tables\Columns\ImageColumn::make('logo')
                    ->label('Logo'),
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
            'index' => Pages\ListHubins::route('/'),
            'create' => Pages\CreateHubin::route('/create'),
            'edit' => Pages\EditHubin::route('/{record}/edit'),
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
        return auth()->user()?->can('view_hubins');
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create_hubins');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('edit_hubins');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete_hubins');
    }
}