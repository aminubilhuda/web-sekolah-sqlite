<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GaleriResource\Pages;
use App\Models\Galeri;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GaleriResource extends Resource
{
    protected static ?string $model = Galeri::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationLabel = 'Galeri';
    protected static ?string $modelLabel = 'Galeri';
    protected static ?string $pluralModelLabel = 'Galeri';
    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('judul')->required(),
            Forms\Components\Textarea::make('deskripsi'),
            Forms\Components\Select::make('kategori')
                ->options([
                    'foto' => 'Foto',
                    'video' => 'Video',
                ])
                ->default('foto')
                ->required()
                ->reactive(),
            Forms\Components\FileUpload::make('gambar')
                ->label('Foto')
                ->image()
                ->multiple()
                ->directory('galeri')
                ->required(fn (Forms\Get $get) => $get('kategori') === 'foto')
                ->visible(fn (Forms\Get $get) => $get('kategori') === 'foto'),
            Forms\Components\TextInput::make('url_video')
                ->label('URL Video')
                ->url()
                ->required(fn (Forms\Get $get) => $get('kategori') === 'video')
                ->visible(fn (Forms\Get $get) => $get('kategori') === 'video'),
            Forms\Components\Toggle::make('is_active')
                ->label('Status Aktif')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('judul')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('kategori')->badge(),
            Tables\Columns\ImageColumn::make('gambar')->label('Foto')->circular(),
            Tables\Columns\TextColumn::make('url_video')->label('URL Video')->limit(30),
            Tables\Columns\IconColumn::make('is_active')->boolean()->label('Status'),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('kategori')
                ->options([
                    'foto' => 'Foto',
                    'video' => 'Video',
                ]),
            Tables\Filters\TernaryFilter::make('is_active')->label('Status Aktif'),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGaleris::route('/'),
            'create' => Pages\CreateGaleri::route('/create'),
            'edit' => Pages\EditGaleri::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->can('view_galeris');
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create_galeris');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('edit_galeris');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete_galeris');
    }
}