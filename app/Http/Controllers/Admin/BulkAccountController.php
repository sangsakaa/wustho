<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Guru;
use Illuminate\Support\Facades\Hash;

class BulkAccountController extends Controller
{
    public function createStudentAccounts()
    {
        $students = Siswa::with('nis')
            ->whereDoesntHave('user')
            ->get();

        $created = 0;

        foreach ($students as $student) {
            if (!$student->nis) {
                continue;
            }

            User::create([
                'name' => $student->nama_siswa,
                'email' => $student->nis->nis . '@school.local',
                'password' => Hash::make($student->nis->nis),
                'siswa_id' => $student->id,
            ])->assignRole('siswa');

            $created++;
        }

        return back()->with(
            'success',
            "{$created} akun siswa berhasil dibuat"
        );
    }

    public function createTeacherAccounts()
    {
        $teachers = Guru::with('nig')
            ->whereDoesntHave('user')
            ->get();

        $created = 0;

        foreach ($teachers as $teacher) {
            if (!$teacher->nig) {
                continue;
            }

            User::create([
                'name' => $teacher->nama_guru,
                'email' => $teacher->nig->nig . '@school.local',
                'password' => Hash::make($teacher->nig->nig),
                'guru_id' => $teacher->id,
            ])->assignRole('guru');

            $created++;
        }

        return back()->with(
            'success',
            "{$created} akun guru berhasil dibuat"
        );
    }
}
