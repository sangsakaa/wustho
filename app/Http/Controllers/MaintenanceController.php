<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

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
    private function formatSize($bytes)
    {
        if ($bytes <= 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $power = floor(log($bytes, 1024));

        return number_format(
            $bytes / pow(1024, $power),
            2
        ) . ' ' . $units[$power];
    }

    public function detail($folder)
    {
        $folders = [
            'logs' => storage_path('logs'),
            'cache' => storage_path('framework/cache'),
            'views' => storage_path('framework/views'),
            'sessions' => storage_path('framework/sessions'),
            'bootstrap' => base_path('bootstrap/cache'),
        ];

        abort_unless(isset($folders[$folder]), 404);

        $path = $folders[$folder];

        $files = [];

        if (File::exists($path)) {

            foreach (File::files($path) as $file) {

                $files[] = [
                    'name' => $file->getFilename(),
                    'size' => $this->formatSize($file->getSize()),
                    'bytes' => $file->getSize(),
                    'modified' => date(
                        'd-m-Y H:i:s',
                        $file->getMTime()
                    ),
                    'path' => $file->getRealPath(),
                ];
            }
        }

        usort($files, function ($a, $b) {
            return $b['bytes'] <=> $a['bytes'];
        });

        return view('maintenance.detail', compact(
            'folder',
            'files'
        ));
    }
    public function viewLog($file)
    {
        $path = storage_path('logs/' . basename($file));

        if (!File::exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        // Maksimal baca 200 baris terakhir
        $lines = [];
        $fp = fopen($path, 'r');

        if ($fp) {
            $buffer = '';
            $pos = -1;
            $lineCount = 0;

            fseek($fp, 0, SEEK_END);
            $filesize = ftell($fp);

            while ($lineCount < 200 && abs($pos) <= $filesize) {

                fseek($fp, $pos, SEEK_END);
                $char = fgetc($fp);

                if ($char === "\n") {
                    $lines[] = strrev($buffer);
                    $buffer = '';
                    $lineCount++;
                } else {
                    $buffer .= $char;
                }

                $pos--;
            }

            if ($buffer != '') {
                $lines[] = strrev($buffer);
            }

            fclose($fp);
        }

        $lines = array_reverse($lines);

        return view('maintenance.log-view', [
            'filename' => basename($file),
            'content' => implode("\n", $lines),
        ]);
    }
    public function downloadLog($file)
    {
        $path = storage_path('logs/' . basename($file));

        abort_unless(File::exists($path), 404);

        return response()->download($path);
    }

    /**
     * Kosongkan isi file log (truncate)
     */
    public function clearLog($file)
    {
        $path = storage_path('logs/' . basename($file));

        abort_unless(File::exists($path), 404);

        // Kosongkan isi file tanpa menghapus file
        file_put_contents($path, '');

        return redirect()
            ->route('maintenance.detail', 'logs')
            ->with('success', basename($file) . ' berhasil dikosongkan.');
    }
    public function analyzer()
    {
        $targets = [
            [
                'name' => 'Laravel Logs',
                'path' => storage_path('logs'),
                'cleanable' => true,
                'action' => 'clear-log',
            ],
            [
                'name' => 'Framework Cache',
                'path' => storage_path('framework/cache'),
                'cleanable' => true,
                'action' => 'cache',
            ],
            [
                'name' => 'Framework Views',
                'path' => storage_path('framework/views'),
                'cleanable' => true,
                'action' => 'view',
            ],
            [
                'name' => 'Framework Sessions',
                'path' => storage_path('framework/sessions'),
                'cleanable' => true,
                'action' => 'sessions',
            ],
            [
                'name' => 'Bootstrap Cache',
                'path' => base_path('bootstrap/cache'),
                'cleanable' => true,
                'action' => 'bootstrap',
            ],
            [
                'name' => 'Storage Public',
                'path' => storage_path('app/public'),
                'cleanable' => false,
                'action' => null,
            ],
            [
                'name' => 'Public Upload',
                'path' => public_path('uploads'),
                'cleanable' => false,
                'action' => null,
            ],
        ];

        $result = [];

        foreach ($targets as $item) {

            if (!File::exists($item['path'])) {
                continue;
            }

            $size = $this->folderBytes($item['path']);

            $result[] = [
                'name' => $item['name'],
                'path' => $item['path'],
                'bytes' => $size,
                'size' => $this->formatSize($size),
                'cleanable' => $item['cleanable'],
                'action' => $item['action'],
                'status' => $this->statusStorage($size),
            ];
        }

        usort($result, fn($a, $b) => $b['bytes'] <=> $a['bytes']);

        return view('maintenance.analyzer', compact('result'));
    }
    private function folderBytes($dir)
    {
        $size = 0;

        if (!File::exists($dir)) {
            return 0;
        }

        foreach (File::allFiles($dir) as $file) {
            $size += $file->getSize();
        }

        return $size;
    }

    private function statusStorage($bytes)
    {
        if ($bytes > 1024 * 1024 * 1024) {
            return 'danger';
        }

        if ($bytes > 300 * 1024 * 1024) {
            return 'warning';
        }

        return 'success';
    }
}
