<?php

namespace App\Providers;

use App\Models\Periode;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

class ViewServiceProvider extends ServiceProvider
{
    public function register() {}

    public function boot()
    {
        View::composer('*', function ($view) {

            try {
                // cek koneksi database dulu
                DB::connection()->getPdo();

                $dataperiode = Periode::getDataPeriode();

                $periodeAktif = Periode::active()->first();

                if ($periodeAktif) {
                    session(['periode_id' => $periodeAktif->id]);
                }

                $view->with('dataperiode', $dataperiode);
                $view->with('dbError', null);
            } catch (\Exception $e) {
                // kalau database mati
                $view->with('dataperiode', collect());
                $view->with('dbError', '⚠️ Database sedang offline atau koneksi gagal.');
            }
        });
    }
}
