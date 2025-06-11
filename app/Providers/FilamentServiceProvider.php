<?php

namespace App\Providers;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class FilamentServiceProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])

            ->widgets([
                \App\Filament\Widgets\StatistikSekolah::class,
            ])
            
            ->navigationItems([
                // Dashboard
                \Filament\Navigation\NavigationItem::make('Dashboard')
                    ->icon('heroicon-o-home')
                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.pages.dashboard'))
                    ->url(fn (): string => route('filament.admin.pages.dashboard'))
                    ->visible(fn (): bool => auth()->user()->can('view_dashboard')),

                // User Management
                \Filament\Navigation\NavigationItem::make('Users')
                    ->icon('heroicon-o-users')
                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.users.*'))
                    ->url(fn (): string => route('filament.admin.resources.users.index'))
                    ->visible(fn (): bool => auth()->user()->can('view_users')),

                // Role & Permission Management
                \Filament\Navigation\NavigationItem::make('Roles & Permissions')
                    ->icon('heroicon-o-shield-check')
                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.roles.*') || request()->routeIs('filament.admin.resources.permissions.*'))
                    ->url(fn (): string => route('filament.admin.resources.roles.index'))
                    ->visible(fn (): bool => auth()->user()->can('view_roles') || auth()->user()->can('view_permissions')),

                // Sekolah Management
                \Filament\Navigation\NavigationItem::make('Sekolah')
                    ->icon('heroicon-o-building-office')
                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.sekolahs.*'))
                    ->url(fn (): string => route('filament.admin.resources.sekolahs.index'))
                    ->visible(fn (): bool => auth()->user()->can('view_sekolahs')),

                // Jurusan Management
                \Filament\Navigation\NavigationItem::make('Jurusan')
                    ->icon('heroicon-o-academic-cap')
                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.jurusans.*'))
                    ->url(fn (): string => route('filament.admin.resources.jurusans.index'))
                    ->visible(fn (): bool => auth()->user()->can('view_jurusans')),

                // Kelas Management
                \Filament\Navigation\NavigationItem::make('Kelas')
                    ->icon('heroicon-o-academic-cap')
                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.kelas.*'))
                    ->url(fn (): string => route('filament.admin.resources.kelas.index'))
                    ->visible(fn (): bool => auth()->user()->can('view_kelas')),

                // PTK Management
                \Filament\Navigation\NavigationItem::make('PTK')
                    ->icon('heroicon-o-user-group')
                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.ptks.*'))
                    ->url(fn (): string => route('filament.admin.resources.ptks.index'))
                    ->visible(fn (): bool => auth()->user()->can('view_ptks')),

                // Siswa Management
                \Filament\Navigation\NavigationItem::make('Siswa')
                    ->icon('heroicon-o-user-group')
                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.siswas.*'))
                    ->url(fn (): string => route('filament.admin.resources.siswas.index'))
                    ->visible(fn (): bool => auth()->user()->can('view_siswas')),

                // Berita Management
                \Filament\Navigation\NavigationItem::make('Berita')
                    ->icon('heroicon-o-newspaper')
                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.beritas.*'))
                    ->url(fn (): string => route('filament.admin.resources.beritas.index'))
                    ->visible(fn (): bool => auth()->user()->can('view_beritas')),

                // Fasilitas Management
                \Filament\Navigation\NavigationItem::make('Fasilitas')
                    ->icon('heroicon-o-building-library')
                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.fasilitas.*'))
                    ->url(fn (): string => route('filament.admin.resources.fasilitas.index'))
                    ->visible(fn (): bool => auth()->user()->can('view_fasilitas')),

                // Ekstrakurikuler Management
                \Filament\Navigation\NavigationItem::make('Ekstrakurikuler')
                    ->icon('heroicon-o-academic-cap')
                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.ekstrakurikulers.*'))
                    ->url(fn (): string => route('filament.admin.resources.ekstrakurikulers.index'))
                    ->visible(fn (): bool => auth()->user()->can('view_ekstrakurikulers')),

                // Hubin Management
                \Filament\Navigation\NavigationItem::make('Hubungan Industri')
                    ->icon('heroicon-o-building-office-2')
                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.hubins.*'))
                    ->url(fn (): string => route('filament.admin.resources.hubins.index'))
                    ->visible(fn (): bool => auth()->user()->can('view_hubins')),
            ]);
            
    }
} 