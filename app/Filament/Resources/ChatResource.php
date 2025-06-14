<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChatResource\Pages;
use App\Models\Chat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ChatResource extends Resource
{
    protected static ?string $model = Chat::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'Riwayat Chat';
    protected static ?string $modelLabel = 'Riwayat Chat';
    protected static ?string $pluralModelLabel = 'Riwayat Chat';
    protected static ?int $navigationSort = 9;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('session_id')
                ->required()
                ->maxLength(255),
            Forms\Components\Textarea::make('message')
                ->required()
                ->maxLength(65535),
            Forms\Components\Textarea::make('response')
                ->maxLength(65535),
            Forms\Components\Toggle::make('is_from_user')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('session_id')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('message')
                ->limit(50)
                ->searchable(),
            Tables\Columns\TextColumn::make('response')
                ->limit(50)
                ->searchable(),
            Tables\Columns\IconColumn::make('is_from_user')
                ->boolean()
                ->label('Dari User'),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('is_from_user')
                ->options([
                    '1' => 'Dari User',
                    '0' => 'Dari Bot',
                ])
                ->label('Sumber Pesan'),
        ])
        ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ])
        ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChats::route('/'),
            'create' => Pages\CreateChat::route('/create'),
            'edit' => Pages\EditChat::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->can('view_chats');
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create_chats');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('edit_chats');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete_chats');
    }
} 