# AGENTS.md — wustho (Smedi)

## Project

Laravel 9 school management system (pesantren/boarding school).
App name: **Smedi**. Locale: `id`, timezone: `Asia/Jakarta`, DB: MySQL.

PHP 8.0+, Laravel 9, Tailwind CSS 3 (dark mode `class`), Alpine.js, Livewire 2, Vite.

## Commands

```bash
npm run dev                   # Vite dev server (assets only)
npm run build                 # Vite production build
php artisan serve             # Laravel dev server
php artisan migrate           # DB migrations
php artisan test              # PHPUnit
```

No linter/formatter/typechecker configured beyond `.editorconfig` + StyleCI (Laravel preset).

## Key Packages

| Purpose | Package |
|---|---|
| Roles/Permissions | `spatie/laravel-permission` |
| Activity Log | `spatie/laravel-activitylog` |
| Attendance QR | `bacon/bacon-qr-code`, `simplesoftwareio/simple-qrcode` |
| PDF | `barryvdh/laravel-dompdf`, `barryvdh/laravel-snappy`, `mpdf/mpdf`, `h4cc/wkhtmltopdf-amd64` |
| Import/Export | `maatwebsite/excel` |
| DataTables | `yajra/laravel-datatables-oracle` |
| Schedules/Calendar | `@fullcalendar/core`, `@fullcalendar/daygrid` |
| Charts | `chart.js` |
| Hijri Dates | `alkoumi/laravel-hijri-date` |
| Number to Words (ID) | `riskihajar/terbilang` |
| Auth UI | Laravel Breeze + KUI theme (`kamona/kui-laravel-breeze`) |

## Architecture

- **Routes**: `routes/web.php` (main), `routes/api.php` (2 endpoints), `routes/auth.php`
- **Auth**: Sanctum + Spatie roles (`role` middleware registered). Admin gate (`Gate::before`) overrides all permissions (`AppServiceProvider`).
- **Dashboards**: `/dashboard`, `/userdashboard`, `/gurudashboard` — redirect targets in `RouteServiceProvider`
- **Period system**: All features scoped to a selected `periode` (academic period). `ViewServiceProvider` globally shares `$dataperiode` and auto-initializes `session('periode_id')`.
- **Artisan commands**: `periode:set-active` (interactive), `periode:filter` (list recent periods)
- **Livewire**: Version 2, class namespace `App\Livewire` (`config/livewire.php`), 11 components in `app/Livewire/` with views in `resources/views/livewire/`, layout `components.layouts.app`. Registered with `@livewireStyles`/`@livewireScripts` (auto-inject enabled).

## Domains (by directory)

| Directory | Purpose |
|---|---|
| `app/Models/Siswa.php` | Students |
| `app/Models/Guru.php` | Teachers |
| `app/Models/Kelasmi.php` / `Kelas.php` | Classes |
| `app/Models/Asrama.php` / `Asramasiswa.php` | Dormitories |
| `app/Models/Sesikelas.php` / `Absensikelas.php` / `Presensikelas.php` | Attendance |
| `app/Models/Nilai.php` / `Nilaimapel.php` | Grades |
| `app/Models/Jadwal.php` / `Daftar_Jadwal.php` | Schedules |
| `app/Models/Lulusan.php` / `Daftar_lulusan.php` | Graduation |
| `app/Models/Periode.php` | Academic periods |
| `app/Models/User.php` | Users (link to `siswa_id` or `guru_id`) |

## Testing

- PHPUnit with `phpunit.xml` (2 suites: Unit + Feature)
- DB defaults to array cache/session, **no SQLite in-memory** — tests may need real DB
- Only placeholder tests exist (`ExampleTest.php`)

## Style

- 4-space indentation, UTF-8, LF line endings (`.editorconfig`)
- Carbon locale set to Indonesian (`'id'`) globally (`AppServiceProvider`)
- Schema default string length: 191 (`AppServiceProvider`)
