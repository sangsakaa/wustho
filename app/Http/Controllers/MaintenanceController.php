<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class MaintenanceController extends Controller
{
    public function index()
    {
        $folders = [
            'Storage' => storage_path(),
            'Logs' => storage_path('logs'),
            'Framework Cache' => storage_path('framework/cache'),
            'Framework Views' => storage_path('framework/views'),
            'Framework Sessions' => storage_path('framework/sessions'),
            'Bootstrap Cache' => base_path('bootstrap/cache'),
            'Public' => public_path(),
            'Vendor' => base_path('vendor'),
            'Node Modules' => base_path('node_modules'),
        ];

        $data = [];

        foreach ($folders as $name => $path) {

            $data[] = [
                'name' => $name,
                'path' => $path,
                'exists' => File::exists($path),
                'size' => File::exists($path)
                    ? $this->formatSize($this->folderSize($path))
                    : '-',
                'files' => File::exists($path)
                    ? count(File::allFiles($path))
                    : 0,
            ];
        }

        return view('maintenance.index', compact('data'));
    }

    private function folderSize($dir)
    {
        $size = 0;

        if (!File::exists($dir))
            return 0;

        foreach (File::allFiles($dir) as $file) {
            $size += $file->getSize();
        }

        return $size;
    }

    private function formatSize($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $i = 0;

        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function optimize()
    {
        Artisan::call('optimize:clear');

        return back()->with('success', 'Optimize Clear berhasil.');
    }

    public function cache()
    {
        Artisan::call('cache:clear');

        return back()->with('success', 'Cache berhasil dibersihkan.');
    }

    public function config()
    {
        Artisan::call('config:clear');

        return back()->with('success', 'Config berhasil dibersihkan.');
    }

    public function routeClear()
    {
        Artisan::call('route:clear');

        return back()->with('success', 'Route berhasil dibersihkan.');
    }

    public function viewClear()
    {
        Artisan::call('view:clear');

        return back()->with('success', 'View berhasil dibersihkan.');
    }
}
