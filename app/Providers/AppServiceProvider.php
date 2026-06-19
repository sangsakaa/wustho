<?php

namespace App\Providers;

use App\Helpers\AppVersion;
use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::share('appVersion', AppVersion::get());
        Event::listen(Login::class, function ($event) {
            activity()
                ->causedBy($event->user)
                ->withProperties([
                    'ip' => request()->ip(),
                    'browser' => request()->userAgent(),
                ])
                ->log('Login');
        });

        Event::listen(Logout::class, function ($event) {
            activity()
                ->causedBy($event->user)
                ->withProperties([
                    'ip' => request()->ip(),
                    'browser' => request()->userAgent(),
                ])
                ->log('Logout');
        });

        // ✅ GLOBAL VIEW COMPOSER (FIX UTAMA KAMU)
        View::composer('*', function ($view) {

            $dataperiode = \App\Models\Periode::getNavbarPeriode();

            $periodeAktif =
                $dataperiode->firstWhere('id', session('periode_id'))
                ?? $dataperiode->firstWhere('is_active', true);

            $view->with([
                'dataperiode' => $dataperiode,
                'periodeAktif' => $periodeAktif,
            ]);
        });

        // ✅ tetap aman (tidak diubah)
        Schema::defaultStringLength(191);

        Carbon::setLocale('id');

        Gate::before(function ($user, $ability) {

            if ($user->hasRole('super admin')) {
                return true;
            }

            return null;
        });
    }
}
