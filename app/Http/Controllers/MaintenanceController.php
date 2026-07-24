<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        if (!is_dir($dir)) {
            return 0;
        }

        if (function_exists('shell_exec')) {

            $size = trim(shell_exec(
                "du -sb " . escapeshellarg($dir) . " 2>/dev/null | cut -f1"
            ));

            return is_numeric($size)
                ? (int)$size
                : 0;
        }

        return 0;
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
    public function hostingAnalyzer()
    {
        $root = dirname(base_path());

        $result = [];

        foreach (File::directories($root) as $dir) {

            $bytes = $this->folderBytes($dir);

            $result[] = [

                'name' => basename($dir),

                'path' => $dir,

                'bytes' => $bytes,

                'size' => $this->formatSize($bytes),

                'status' => $this->statusStorage($bytes),

                'cleanable' => in_array(
                    strtolower(basename($dir)),
                    [
                        'logs',
                        'cache',
                        'sessions',
                        'tmp',
                        'backup'
                    ]
                ),

                'recommendation' => $this->recommendation(
                    basename($dir),
                    $bytes
                ),

            ];
        }

        usort($result, fn($a, $b) => $b['bytes'] <=> $a['bytes']);

        return view('maintenance.hosting-analyzer', compact('result'));
    }
    private function recommendation($folder, $bytes)
    {
        $folder = strtolower($folder);

        if ($folder == "logs") {
            return [
                'status' => 'Aman',
                'color' => 'warning',
                'message' => 'Log dapat dibersihkan.'
            ];
        }

        if ($folder == "tmp") {
            return [
                'status' => 'Aman',
                'color' => 'warning',
                'message' => 'Temporary dapat dihapus.'
            ];
        }

        if ($folder == "backup") {
            return [
                'status' => 'Aman',
                'color' => 'danger',
                'message' => 'Backup lama dapat dihapus.'
            ];
        }

        if ($folder == "mail") {
            return [
                'status' => 'Periksa',
                'color' => 'danger',
                'message' => 'Email sering memenuhi storage.'
            ];
        }

        if ($folder == "vendor") {
            return [
                'status' => 'Jangan',
                'color' => 'secondary',
                'message' => 'Folder Laravel.'
            ];
        }

        if ($folder == "storage") {
            return [
                'status' => 'Analisa',
                'color' => 'info',
                'message' => 'Periksa log dan upload.'
            ];
        }

        return [
            'status' => 'Periksa',
            'color' => 'secondary',
            'message' => 'Belum diketahui.'
        ];
    }
    public function deleteFolder(Request $request)
    {
        $path = $request->path;

        if (!File::exists($path)) {
            return back()->with('error', 'Folder tidak ditemukan.');
        }

        File::deleteDirectory($path);

        return back()->with('success', 'Folder berhasil dihapus.');
    }
}
