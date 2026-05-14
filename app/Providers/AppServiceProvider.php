<?php

namespace App\Providers;

use Carbon\Carbon;
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
        // ✅ GLOBAL VIEW COMPOSER (FIX UTAMA KAMU)
        View::composer('*', function ($view) {

            $dataperiode = \App\Models\Periode::getDataPeriode();

            $periodeAktif = $dataperiode->firstWhere('id', session('periode_id'))
                ?? $dataperiode->firstWhere('is_active', 1);

            $view->with('periodeAktif', $periodeAktif);
        });

        // ✅ tetap aman (tidak diubah)
        Schema::defaultStringLength(191);

        Carbon::setLocale('id');

        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });
    }
}
