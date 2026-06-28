<?php

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register()
    {
        $siswa = \App\Models\Siswa::create([
            'nama_siswa' => 'Test Siswa',
            'jenis_kelamin' => 'L',
            'agama' => 'Islam',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2010-01-01',
            'kota_asal' => 'Jakarta',
        ]);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'siswa_id' => $siswa->id,
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'siswa_id' => $siswa->id,
        ]);

        $response->assertRedirect(route('register.index'));
    }
}
