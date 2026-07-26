<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
  public function login(string $email, string $password): array
  {
    $user = User::with(['siswa', 'guru'])
      ->where('email', $email)
      ->first();

    if (!$user || !Hash::check($password, $user->password)) {
      throw ValidationException::withMessages([
        'email' => ['Email atau password salah.'],
      ]);
    }

    $user->tokens()->delete();

    $token = $user->createToken('flutter-mobile')->plainTextToken;

    return [
      'token' => $token,
      'user'  => $user,
    ];
  }

  public function logout(User $user): void
  {
    $user->currentAccessToken()?->delete();
  }
}
