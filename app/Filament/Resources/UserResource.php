<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\Siswa;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Manajemen User';

    protected static ?string $modelLabel = 'User';

    protected static ?string $pluralModelLabel = 'Users';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi User')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('username')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->required()
                            ->minLength(8)
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create'),
                        Forms\Components\Select::make('roles')
                            ->multiple()
                            ->relationship('roles', 'name')
                            ->preload()
                            ->searchable(),
                        Forms\Components\FileUpload::make('avatar')
                            ->image()
                            ->directory('avatars')
                            ->nullable(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('username')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->badge()
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Status'),
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
                Tables\Filters\SelectFilter::make('roles')
                    ->relationship('roles', 'name'),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                Action::make('generateSiswa')
                    ->label('Generate User Siswa')
                    ->icon('heroicon-o-user-plus')
                    ->color('success')
                    ->action(function () {
                        $siswas = Siswa::whereDoesntHave('user')->get();
                        
                        if ($siswas->isEmpty()) {
                            Notification::make()
                                ->title('Tidak ada siswa yang perlu digenerate')
                                ->warning()
                                ->send();
                            return;
                        }

                        $count = 0;
                        foreach ($siswas as $siswa) {
                            $user = User::create([
                                'name' => $siswa->nama,
                                'email' => $siswa->email ?? $siswa->nis . '@siswa.sch.id',
                                'username' => $siswa->nis,
                                'password' => Hash::make($siswa->nis),
                                'is_active' => true,
                                'id_siswa' => $siswa->id_siswa
                            ]);

                            $user->assignRole('siswa');
                            $count++;
                        }

                        Notification::make()
                            ->title("Berhasil generate {$count} user siswa")
                            ->success()
                            ->send();
                    }),
                Action::make('selectSiswa')
                    ->label('Pilih Siswa')
                    ->icon('heroicon-o-user-group')
                    ->color('primary')
                    ->form([
                        Forms\Components\Select::make('siswa_id')
                            ->label('Pilih Siswa')
                            ->options(Siswa::whereDoesntHave('user')->pluck('nama', 'id_siswa'))
                            ->searchable()
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        $siswa = Siswa::find($data['siswa_id']);
                        
                        $user = User::create([
                            'name' => $siswa->nama,
                            'email' => $siswa->email ?? $siswa->nis . '@siswa.sch.id',
                            'username' => $siswa->nis,
                            'password' => Hash::make($siswa->nis),
                            'is_active' => true,
                            'id_siswa' => $siswa->id_siswa
                        ]);

                        $user->assignRole('siswa');

                        Notification::make()
                            ->title("Berhasil membuat user untuk {$siswa->nama}")
                            ->success()
                            ->send();
                    }),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->can('view_users');
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create_users');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('edit_users');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete_users');
    }
} 