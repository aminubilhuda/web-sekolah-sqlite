<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EkstrakurikulerResource\Pages;
use App\Filament\Resources\EkstrakurikulerResource\RelationManagers;
use App\Models\Ekstrakurikuler;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Filament\Notifications\Notification;

class EkstrakurikulerResource extends Resource
{
    protected static ?string $model = Ekstrakurikuler::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Ekstrakurikuler';
    protected static ?string $modelLabel = 'Ekstrakurikuler';
    protected static ?string $pluralModelLabel = 'Ekstrakurikuler';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Ekstrakurikuler')
                    ->schema([
                        Forms\Components\TextInput::make('nama_ekstrakurikuler')
                            ->required()
                            ->maxLength(255)
                            ->label('Nama Ekstrakurikuler'),
                        Forms\Components\Actions::make([
                            Forms\Components\Actions\Action::make('generate_deskripsi')
                                ->label('Generate Deskripsi dengan AI')
                                ->icon('heroicon-o-sparkles')
                                ->action(function (Forms\Get $get, Forms\Set $set) {
                                    $nama_ekstrakurikuler = $get('nama_ekstrakurikuler');
                                    $pembina = $get('pembina');
                                    
                                    if (empty($nama_ekstrakurikuler)) {
                                        Notification::make()
                                            ->title('Nama Ekstrakurikuler harus diisi')
                                            ->warning()
                                            ->send();
                                        return;
                                    }

                                    $apiKey = Setting::getValue('gemini_api_key');
                                    if (empty($apiKey)) {
                                        Notification::make()
                                            ->title('API Key Gemini belum diatur')
                                            ->warning()
                                            ->send();
                                        return;
                                    }

                                    try {
                                        $prompt = "Buatkan deskripsi lengkap untuk ekstrakurikuler {$nama_ekstrakurikuler}" . 
                                                ($pembina ? " dengan pembina {$pembina}" : "") . 
                                                ". Deskripsi harus mencakup: 
                                                1. Penjelasan umum tentang ekstrakurikuler
                                                2. Tujuan dan manfaat mengikuti ekstrakurikuler
                                                3. Kegiatan-kegiatan yang dilakukan
                                                4. Prestasi dan pencapaian ekstrakurikuler
                                                5. Keterampilan yang akan didapatkan
                                                Gunakan format HTML dengan tag <h2> untuk judul setiap bagian dan <p> untuk paragraf. Tambahkan <ul> dan <li> untuk daftar poin.";
                                        
                                        $response = Http::withHeaders([
                                            'Content-Type' => 'application/json',
                                        ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}", [
                                            'contents' => [
                                                ['parts' => [['text' => $prompt]]]
                                            ]
                                        ]);

                                        if ($response->successful()) {
                                            $content = $response->json()['candidates'][0]['content']['parts'][0]['text'];
                                            if (!str_contains($content, '<html>')) {
                                                $content = '<div class="prose max-w-none">' . $content . '</div>';
                                            }
                                            $set('deskripsi', $content);
                                            
                                            Notification::make()
                                                ->title('Deskripsi berhasil digenerate')
                                                ->success()
                                                ->send();
                                        } else {
                                            Notification::make()
                                                ->title('Gagal generate deskripsi')
                                                ->body('Terjadi kesalahan: ' . $response->body())
                                                ->danger()
                                                ->send();
                                        }
                                    } catch (\Exception $e) {
                                        Notification::make()
                                            ->title('Gagal generate deskripsi')
                                            ->body('Terjadi kesalahan: ' . $e->getMessage())
                                            ->danger()
                                            ->send();
                                    }
                                })
                        ]),
                        Forms\Components\RichEditor::make('deskripsi')
                            ->label('Deskripsi')
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'h2',
                                'h3',
                                'bulletList',
                                'orderedList',
                                'redo',
                                'undo',
                            ]),
                        Forms\Components\TextInput::make('pembina')
                            ->maxLength(255)
                            ->label('Pembina'),
                    ])->columns(2),

                Forms\Components\Section::make('Jadwal Kegiatan')
                    ->schema([
                        Forms\Components\Select::make('hari_kegiatan')
                            ->options([
                                'Senin' => 'Senin',
                                'Selasa' => 'Selasa',
                                'Rabu' => 'Rabu',
                                'Kamis' => 'Kamis',
                                'Jumat' => 'Jumat',
                                'Sabtu' => 'Sabtu',
                                'Minggu' => 'Minggu',
                            ])
                            ->label('Hari Kegiatan'),
                        Forms\Components\TimePicker::make('jam_mulai')
                            ->label('Jam Mulai'),
                        Forms\Components\TimePicker::make('jam_selesai')
                            ->label('Jam Selesai'),
                        Forms\Components\TextInput::make('tempat_kegiatan')
                            ->maxLength(255)
                            ->label('Tempat Kegiatan'),
                    ])->columns(2),

                Forms\Components\Section::make('Media')
                    ->schema([
                        Forms\Components\FileUpload::make('foto')
                            ->image()
                            ->directory('public/ekstrakurikuler')
                            ->label('Foto Ekstrakurikuler'),
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
                Tables\Columns\TextColumn::make('nama_ekstrakurikuler')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Ekstrakurikuler'),
                Tables\Columns\TextColumn::make('pembina')
                    ->searchable()
                    ->sortable()
                    ->label('Pembina'),
                Tables\Columns\TextColumn::make('hari_kegiatan')
                    ->searchable()
                    ->sortable()
                    ->label('Hari'),
                Tables\Columns\TextColumn::make('jam_mulai')
                    ->time()
                    ->sortable()
                    ->label('Jam Mulai'),
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
            'index' => Pages\ListEkstrakurikulers::route('/'),
            'create' => Pages\CreateEkstrakurikuler::route('/create'),
            'edit' => Pages\EditEkstrakurikuler::route('/{record}/edit'),
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
        return auth()->user()?->can('view_ekstrakurikulers');
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create_ekstrakurikulers');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('edit_ekstrakurikulers');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete_ekstrakurikulers');
    }
}