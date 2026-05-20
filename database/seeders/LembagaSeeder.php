<?php

namespace Database\Seeders;

use App\Models\Lembaga;
use Illuminate\Database\Seeder;

class LembagaSeeder extends Seeder
{
    public function run(): void
    {
        Lembaga::insert([
            [
                'kode' => 'ULA',
                'nama' => 'Ula',
                'deskripsi' => 'Jenjang pendidikan dasar Wahidiyah',
            ],
            [
                'kode' => 'WST',
                'nama' => 'Wustho',
                'deskripsi' => 'Jenjang pendidikan menengah Wahidiyah',
            ],
            [
                'kode' => 'ULY',
                'nama' => 'Ulya',
                'deskripsi' => 'Jenjang pendidikan lanjutan Wahidiyah',
            ],
        ]);
    }
}
