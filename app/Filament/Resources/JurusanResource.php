<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JurusanResource\Pages;
use App\Filament\Resources\JurusanResource\RelationManagers;
use App\Models\Jurusan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Filament\Notifications\Notification;

class JurusanResource extends Resource
{
    protected static ?string $model = Jurusan::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Jurusan';

    protected static ?string $modelLabel = 'Data Jurusan';

    protected static ?string $pluralModelLabel = 'Data Jurusan';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Jurusan')
                    ->schema([
                        Forms\Components\TextInput::make('kode_jurusan')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(10),
                        Forms\Components\TextInput::make('nama_jurusan')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ($operation === 'create') {
                                    $set('slug', Str::slug($state));
                                }
                            }),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->disabled()
                            ->dehydrated(),
                        Forms\Components\TextInput::make('kepala_jurusan')
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make('Deskripsi')
                    ->schema([
                        Forms\Components\Textarea::make('deskripsi_singkat')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\Actions::make([
                            Forms\Components\Actions\Action::make('generate_deskripsi')
                                ->label('Generate Deskripsi dengan AI')
                                ->icon('heroicon-o-sparkles')
                                ->action(function (Forms\Get $get, Forms\Set $set) {
                                    $nama_jurusan = $get('nama_jurusan');
                                    $kepala_jurusan = $get('kepala_jurusan');
                                    
                                    if (empty($nama_jurusan)) {
                                        Notification::make()
                                            ->title('Nama Jurusan harus diisi')
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
                                        $prompt = "Buatkan deskripsi lengkap untuk jurusan {$nama_jurusan}" . 
                                                ($kepala_jurusan ? " dengan kepala jurusan {$kepala_jurusan}" : "") . 
                                                ". Deskripsi harus mencakup: 
                                                1. Penjelasan umum tentang jurusan
                                                2. Kompetensi yang akan dipelajari
                                                3. Prospek karir lulusan
                                                4. Fasilitas dan sarana pendukung
                                                5. Prestasi dan pencapaian jurusan
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
                                            
                                            // Generate deskripsi singkat
                                            $promptSingkat = "Buatkan deskripsi singkat (maksimal 2 kalimat) untuk jurusan {$nama_jurusan} yang mencakup fokus utama jurusan dan prospek karir utamanya.";
                                            
                                            $responseSingkat = Http::withHeaders([
                                                'Content-Type' => 'application/json',
                                            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}", [
                                                'contents' => [
                                                    ['parts' => [['text' => $promptSingkat]]]
                                                ]
                                            ]);

                                            if ($responseSingkat->successful()) {
                                                $deskripsiSingkat = $responseSingkat->json()['candidates'][0]['content']['parts'][0]['text'];
                                                $set('deskripsi_singkat', strip_tags($deskripsiSingkat));
                                            }
                                            
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
                            ->required()
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
                        Forms\Components\FileUpload::make('gambar')
                            ->image()
                            ->directory('public/jurusan/gambar')
                            ->nullable()
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Statistik')
                    ->schema([
                        Forms\Components\TextInput::make('jumlah_guru')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Forms\Components\TextInput::make('jumlah_siswa')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'Aktif' => 'Aktif',
                                'Tidak Aktif' => 'Tidak Aktif',
                            ])
                            ->default('Aktif')
                            ->required(),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_jurusan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_jurusan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kepala_jurusan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jumlah_guru')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah_siswa')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListJurusans::route('/'),
            'create' => Pages\CreateJurusan::route('/create'),
            'edit' => Pages\EditJurusan::route('/{record}/edit'),
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
        return auth()->user()?->can('view_jurusans');
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create_jurusans');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('edit_jurusans');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete_jurusans');
    }
}