<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Filament\Resources\SettingResource\RelationManagers;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Pengaturan';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('key')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->disabled()
                    ->dehydrated(false),
                Forms\Components\TextInput::make('value')
                    ->required()
                    ->maxLength(255)
                    ->suffixAction(
                        Action::make('test_connection')
                            ->label('Test')
                            ->icon('heroicon-o-play')
                            ->action(function (Forms\Get $get) {
                                $key = $get('key');
                                $value = $get('value');

                                if ($key === 'gemini_api_key') {
                                    try {
                                        $response = Http::withHeaders([
                                            'Content-Type' => 'application/json',
                                        ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$value}", [
                                            'contents' => [
                                                ['parts' => [['text' => 'Test connection']]]
                                            ]
                                        ]);

                                        if ($response->successful()) {
                                            Notification::make()
                                                ->title('Koneksi Berhasil')
                                                ->success()
                                                ->send();
                                        } else {
                                            Notification::make()
                                                ->title('Koneksi Gagal')
                                                ->body('API Key tidak valid atau terjadi kesalahan: ' . $response->body())
                                                ->danger()
                                                ->send();
                                        }
                                    } catch (\Exception $e) {
                                        Notification::make()
                                            ->title('Koneksi Gagal')
                                            ->body('Terjadi kesalahan: ' . $e->getMessage())
                                            ->danger()
                                            ->send();
                                    }
                                } elseif ($key === 'fontte_api_key') {
                                    try {
                                        $response = Http::withHeaders([
                                            'Authorization' => 'Bearer ' . $value,
                                        ])->get('https://api.fontte.com/v1/fonts');

                                        if ($response->successful()) {
                                            Notification::make()
                                                ->title('Koneksi Berhasil')
                                                ->success()
                                                ->send();
                                        } else {
                                            Notification::make()
                                                ->title('Koneksi Gagal')
                                                ->body('API Key tidak valid atau terjadi kesalahan')
                                                ->danger()
                                                ->send();
                                        }
                                    } catch (\Exception $e) {
                                        Notification::make()
                                            ->title('Koneksi Gagal')
                                            ->body('Terjadi kesalahan: ' . $e->getMessage())
                                            ->danger()
                                            ->send();
                                    }
                                }
                            })
                            ->visible(fn (Forms\Get $get) => in_array($get('key'), ['gemini_api_key', 'fontte_api_key']))
                    ),
                Forms\Components\TextInput::make('description')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->searchable(),
                Tables\Columns\TextColumn::make('value')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}