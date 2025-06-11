<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InfaqResource\Pages;
use App\Filament\Resources\InfaqResource\RelationManagers;
use App\Models\Infaq;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InfaqResource extends Resource
{
    protected static ?string $model = Infaq::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('id_kelas')
                    ->relationship('kelas', 'nama_kelas')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('nama_penyetor'),
                Forms\Components\DatePicker::make('tanggal')
                    ->required()
                    ->default(now())
                    ->date('d M Y')
                    ->format('d M Y'),
                Forms\Components\TextInput::make('jumlah')
                    ->required()
                    ->numeric()
                    ->prefix('Rp '),
                Forms\Components\Textarea::make('keterangan')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kelas.nama_kelas')
                    ->label('Kelas')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_penyetor')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah')
                    ->money('IDR', true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('keterangan')
                    ->limit(30),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListInfaqs::route('/'),
            'create' => Pages\CreateInfaq::route('/create'),
            'edit' => Pages\EditInfaq::route('/{record}/edit'),
        ];
    }
        public static function canViewAny(): bool
    {
        return auth()->user()?->can('view_infaqs');
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create_infaqs');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('edit_infaqs');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete_infaqs');
    }
}