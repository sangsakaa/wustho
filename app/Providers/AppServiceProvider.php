<?php

namespace App\Providers;

use App\Helpers\AppVersion;
use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;


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

            try {

                $dataperiode = \App\Models\Periode::getNavbarPeriode();

                $periodeAktif = null;

                if (session()->has('periode_id')) {
                    $periodeAktif = $dataperiode->firstWhere('id', session('periode_id'));
                }

                if (!$periodeAktif) {
                    $periodeAktif = $dataperiode->firstWhere('is_active', true);
                }
            } catch (\Throwable $e) {

                $dataperiode = collect();
                $periodeAktif = null;
            }

            $view->with([
                'dataperiode' => $dataperiode,
                'periodeAktif' => $periodeAktif,
            ]);
        });

        // ✅ tetap aman (tidak diubah)
        Schema::defaultStringLength(191);

        Carbon::setLocale('id');

        Gate::before(function ($user, $ability) {

            try {

                if ($user && $user->hasRole('super admin')) {
                    return true;
                }
            } catch (\Throwable $e) {
                return null;
            }

            return null;
        });
    }
}
