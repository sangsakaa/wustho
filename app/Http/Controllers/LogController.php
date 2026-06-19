<?php

namespace App\Http\Controllers;

use Spatie\Activitylog\Models\Activity;

class LogController extends Controller
{
    public function index()
    {
    ;    
    $logs = Activity::with('causer')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.logs.index', compact('logs'));
    }
}
