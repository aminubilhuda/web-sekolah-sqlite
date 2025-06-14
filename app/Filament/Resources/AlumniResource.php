<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlumniResource\Pages;
use App\Models\Alumni;
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

class AlumniResource extends Resource
{
    protected static ?string $model = Alumni::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Alumni';

    protected static ?string $pluralModelLabel = 'Alumni';

    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Alumni')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('id_jurusan')
                            ->relationship('jurusan', 'nama_jurusan')
                            ->required(),
                        Forms\Components\DatePicker::make('tahun_lulus')
                            ->required()
                            ->displayFormat('Y')
                            ->format('Y'),
                        Forms\Components\Select::make('status')
                            ->options([
                                'bekerja' => 'Bekerja',
                                'kuliah' => 'Kuliah',
                                'wirausaha' => 'Wirausaha',
                            ])
                            ->required()
                            ->live(),
                        Forms\Components\TextInput::make('pekerjaan')
                            ->maxLength(255)
                            ->required(fn (Forms\Get $get): bool => $get('status') === 'bekerja')
                            ->visible(fn (Forms\Get $get): bool => $get('status') === 'bekerja'),
                        Forms\Components\TextInput::make('perguruan_tinggi')
                            ->maxLength(255)
                            ->required(fn (Forms\Get $get): bool => $get('status') === 'kuliah')
                            ->visible(fn (Forms\Get $get): bool => $get('status') === 'kuliah'),
                        Forms\Components\TextInput::make('jurusan_kuliah')
                            ->maxLength(255)
                            ->required(fn (Forms\Get $get): bool => $get('status') === 'kuliah')
                            ->visible(fn (Forms\Get $get): bool => $get('status') === 'kuliah'),
                    ])->columns(2),

                Forms\Components\Section::make('Testimoni')
                    ->schema([
                        Forms\Components\Actions::make([
                            Forms\Components\Actions\Action::make('generate_testimoni')
                                ->label('Generate Testimoni dengan AI')
                                ->icon('heroicon-o-sparkles')
                                ->action(function (Forms\Get $get, Forms\Set $set) {
                                    $nama = $get('nama');
                                    $status = $get('status');
                                    $pekerjaan = $get('pekerjaan');
                                    $perguruan_tinggi = $get('perguruan_tinggi');
                                    $jurusan_kuliah = $get('jurusan_kuliah');
                                    
                                    if (empty($nama)) {
                                        Notification::make()
                                            ->title('Nama harus diisi')
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
                                        $statusInfo = match($status) {
                                            'bekerja' => "bekerja sebagai {$pekerjaan}",
                                            'kuliah' => "kuliah di {$perguruan_tinggi} jurusan {$jurusan_kuliah}",
                                            'wirausaha' => "berwirausaha",
                                            default => ""
                                        };

                                        $prompt = "Buatkan testimoni singkat dan inspiratif dari alumni sekolah dengan nama {$nama} yang saat ini {$statusInfo}. Testimoni harus mencakup pengalaman selama di sekolah, kesan, dan pesan untuk adik-adik kelas. Gunakan bahasa yang santun dan formal. Format dalam HTML dengan tag <p> untuk setiap paragraf.";
                                        
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
                                            $set('testimoni', $content);
                                            
                                            Notification::make()
                                                ->title('Testimoni berhasil digenerate')
                                                ->success()
                                                ->send();
                                        } else {
                                            Notification::make()
                                                ->title('Gagal generate testimoni')
                                                ->body('Terjadi kesalahan: ' . $response->body())
                                                ->danger()
                                                ->send();
                                        }
                                    } catch (\Exception $e) {
                                        Notification::make()
                                            ->title('Gagal generate testimoni')
                                            ->body('Terjadi kesalahan: ' . $e->getMessage())
                                            ->danger()
                                            ->send();
                                    }
                                })
                        ]),
                        Forms\Components\RichEditor::make('testimoni')
                            ->required()
                            ->maxLength(65535)
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'bulletList',
                                'orderedList',
                                'redo',
                                'undo',
                            ]),
                        Forms\Components\FileUpload::make('foto')
                            ->image()
                            ->directory('alumni')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto')
                    ->circular(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jurusan.nama_jurusan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tahun_lulus')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'bekerja' => 'success',
                        'kuliah' => 'info',
                        'wirausaha' => 'warning',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'bekerja' => 'Bekerja',
                        'kuliah' => 'Kuliah',
                        'wirausaha' => 'Wirausaha',
                    ]),
                Tables\Filters\SelectFilter::make('jurusan')
                    ->relationship('jurusan', 'nama_jurusan'),
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
            'index' => Pages\ListAlumni::route('/'),
            'create' => Pages\CreateAlumni::route('/create'),
            'edit' => Pages\EditAlumni::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->can('view_alumnis');
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create_alumnis');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('edit_alumnis');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete_alumnis');
    }
}