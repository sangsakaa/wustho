<?php

namespace App\Providers;

use App\Models\Periode;
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
            $dataperiode = Periode::query()
                ->join('semester', 'semester.id', '=', 'periode.semester_id')
                ->select('periode.id', 'periode.periode', 'semester.ket_semester')
                ->get();
            $view->with('dataperiode', $dataperiode);
        });
    }
}