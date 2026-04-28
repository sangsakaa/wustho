<?php

namespace App\Providers;

use App\Models\Periode;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        View::composer('*', function ($view) {

            $dataperiode = Periode::getDataPeriode();

            // 🔥 jaga session tetap valid
            if (session('periode_id')) {
                $cek = $dataperiode->firstWhere('id', session('periode_id'));

                if (!$cek && $dataperiode->count()) {
                    session(['periode_id' => $dataperiode->first()->id]);
                }
            } else {
                // default pertama kali
                if ($dataperiode->count()) {
                    session(['periode_id' => $dataperiode->first()->id]);
                }
            }

            $view->with('dataperiode', $dataperiode);
        });
    }
}