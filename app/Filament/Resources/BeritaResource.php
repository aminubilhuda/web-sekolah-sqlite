<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BeritaResource\Pages;
use App\Filament\Resources\BeritaResource\RelationManagers;
use App\Models\Berita;
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
use Filament\Forms\Components\Actions\Action;
use Filament\Notifications\Notification;

class BeritaResource extends Resource
{
    protected static ?string $model = Berita::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationLabel = 'Berita';
    protected static ?string $modelLabel = 'Data Berita';
    protected static ?string $pluralModelLabel = 'Data Berita';
    protected static ?int $navigationSort = 9;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Berita')
                    ->schema([
                        Forms\Components\TextInput::make('judul')
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
                        Forms\Components\Select::make('kategori')
                            ->options([
                                'Akademik' => 'Akademik',
                                'Kegiatan' => 'Kegiatan',
                                'Prestasi' => 'Prestasi',
                                'Pengumuman' => 'Pengumuman',
                                'Lainnya' => 'Lainnya',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('penulis')
                            ->required()
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make('Konten')
                    ->schema([
                        Forms\Components\FileUpload::make('gambar')
                            ->image()
                            ->directory('public/berita/gambar')
                            ->nullable(),
                        Forms\Components\Actions::make([
                            Forms\Components\Actions\Action::make('generate_content')
                                ->label('Generate dengan AI')
                                ->icon('heroicon-o-sparkles')
                                ->action(function (Forms\Get $get, Forms\Set $set) {
                                    $judul = $get('judul');
                                    $kategori = $get('kategori');
                                    
                                    if (empty($judul) || empty($kategori)) {
                                        Notification::make()
                                            ->title('Judul dan Kategori harus diisi')
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
                                        $prompt = "Buatkan berita sekolah dengan judul '{$judul}' dalam kategori {$kategori}. Berita harus informatif, menarik, dan sesuai dengan konteks sekolah. Format berita harus dalam HTML dengan paragraf yang terstruktur. Gunakan tag HTML seperti <p>, <h2>, <h3>, <ul>, <li>, <strong>, <em> untuk memformat teks.";
                                        
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
                                            $set('isi', $content);
                                            
                                            Notification::make()
                                                ->title('Berita berhasil digenerate')
                                                ->success()
                                                ->send();
                                        } else {
                                            Notification::make()
                                                ->title('Gagal generate berita')
                                                ->body('Terjadi kesalahan: ' . $response->body())
                                                ->danger()
                                                ->send();
                                        }
                                    } catch (\Exception $e) {
                                        Notification::make()
                                            ->title('Gagal generate berita')
                                            ->body('Terjadi kesalahan: ' . $e->getMessage())
                                            ->danger()
                                            ->send();
                                    }
                                })
                        ]),
                        Forms\Components\RichEditor::make('isi')
                            ->required()
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'attachFiles',
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ]),
                    ]),

                Forms\Components\Section::make('Status')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'Draft' => 'Draft',
                                'Published' => 'Published',
                            ])
                            ->default('Draft')
                            ->required(),
                        Forms\Components\Select::make('headline')
                            ->options([
                                'Yes' => 'Ya',
                                'No' => 'Tidak',
                            ])
                            ->default('No')
                            ->required(),
                        Forms\Components\DateTimePicker::make('tanggal_publish')
                            ->nullable()
                            ->visible(fn (Forms\Get $get) => $get('status') === 'Published'),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('gambar')
                    ->label('Gambar'),
                Tables\Columns\TextColumn::make('judul')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('kategori')
                    ->badge(),
                Tables\Columns\TextColumn::make('penulis')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Published' => 'success',
                        'Draft' => 'warning',
                    }),
                Tables\Columns\TextColumn::make('headline')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Yes' => 'danger',
                        'No' => 'gray',
                    }),
                Tables\Columns\TextColumn::make('tanggal_publish')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->label('Tanggal Publish'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->options([
                        'Akademik' => 'Akademik',
                        'Kegiatan' => 'Kegiatan',
                        'Prestasi' => 'Prestasi',
                        'Pengumuman' => 'Pengumuman',
                        'Lainnya' => 'Lainnya',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Draft' => 'Draft',
                        'Published' => 'Published',
                    ]),
                Tables\Filters\SelectFilter::make('headline')
                    ->options([
                        'Yes' => 'Ya',
                        'No' => 'Tidak',
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
            'index' => Pages\ListBeritas::route('/'),
            'create' => Pages\CreateBerita::route('/create'),
            'edit' => Pages\EditBerita::route('/{record}/edit'),
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
        return auth()->user()?->can('view_beritas');
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create_beritas');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('edit_beritas');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete_beritas');
    }
}