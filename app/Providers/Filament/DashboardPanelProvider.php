<?php

namespace App\Providers\Filament;

use App\Filament\Dashboard\Pages\CustomDashboard;
use App\Filament\Dashboard\Widgets\ConnectTelegramBanner;
use App\Filament\Pages\Auth\EditProfile;
use App\Filament\Pages\Auth\Login;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\View\View;
use TomatoPHP\FilamentLanguageSwitcher\FilamentLanguageSwitcherPlugin;

class DashboardPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('dashboard')
            ->path('dashboard')
            ->login(Login::class)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Dashboard/Resources'), for: 'App\\Filament\\Dashboard\\Resources')
            ->discoverPages(in: app_path('Filament/Dashboard/Pages'), for: 'App\\Filament\\Dashboard\\Pages')
            ->pages([
                CustomDashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Dashboard/Widgets'), for: 'App\\Filament\\Dashboard\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class, // Included in CustomDashboard
                // Widgets\FilamentInfoWidget::class,
                //ConnectTelegramBanner::class,
            ])
            ->renderHook(
                PanelsRenderHook::USER_MENU_BEFORE,
                fn (): View => \view('filament.hooks.custom-topbar-link')
            )
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
            ->profile(EditProfile::class)
            ->sidebarCollapsibleOnDesktop()
            ->plugin(
                FilamentLanguageSwitcherPlugin::make()
            )
            ->authMiddleware([
                Authenticate::class,
            ])
            //->emailVerification()
            //->passwordReset()
            ->registration();
    }
}
