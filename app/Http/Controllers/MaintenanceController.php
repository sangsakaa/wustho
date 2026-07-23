<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class MaintenanceController extends Controller
{
    public function index()
    {
        $folders = [
            [
                'name' => 'Storage',
                'path' => storage_path(),
            ],
            [
                'name' => 'Logs',
                'path' => storage_path('logs'),
            ],
            [
                'name' => 'Framework Cache',
                'path' => storage_path('framework/cache'),
            ],
            [
                'name' => 'Framework Views',
                'path' => storage_path('framework/views'),
            ],
            [
                'name' => 'Framework Sessions',
                'path' => storage_path('framework/sessions'),
            ],
            [
                'name' => 'Bootstrap Cache',
                'path' => base_path('bootstrap/cache'),
            ],
            [
                'name' => 'Public',
                'path' => public_path(),
            ],
            [
                'name' => 'Vendor',
                'path' => base_path('vendor'),
            ],
            [
                'name' => 'Node Modules',
                'path' => base_path('node_modules'),
            ],
        ];

        $data = [];

        foreach ($folders as $folder) {

            $data[] = [
                'name'   => $folder['name'],
                'path'   => $folder['path'],
                'exists' => is_dir($folder['path']),
                'size'   => $this->getFolderSize($folder['path']),
            ];
        }

        return view('maintenance.index', compact('data'));
    }

    /**
     * Mengambil ukuran folder TANPA membaca semua file.
     */
    private function getFolderSize($path)
    {
        if (!is_dir($path)) {
            return '-';
        }

        // Linux / Hosting / cPanel
        if (function_exists('shell_exec')) {

            $result = @shell_exec(
                'du -sh '
                    . escapeshellarg($path)
                    . ' 2>/dev/null'
            );

            if (!empty($result)) {

                $parts = preg_split('/\s+/', trim($result));

                return $parts[0] ?? '-';
            }
        }

        // Fallback jika shell_exec dimatikan hosting
        return '-';
    }

    public function optimize()
    {
        Artisan::call('optimize:clear');

        return back()->with('success', Artisan::output());
    }

    public function cache()
    {
        Artisan::call('cache:clear');

        return back()->with('success', Artisan::output());
    }

    public function config()
    {
        Artisan::call('config:clear');

        return back()->with('success', Artisan::output());
    }

    public function routeClear()
    {
        Artisan::call('route:clear');

        return back()->with('success', Artisan::output());
    }

    public function viewClear()
    {
        Artisan::call('view:clear');

        return back()->with('success', Artisan::output());
    }
}
