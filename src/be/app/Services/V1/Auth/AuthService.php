<?php

namespace App\Services\V1\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class AuthService implements AuthServiceInterface
{
    public function login(array $credentials): array
    {
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw new \Illuminate\Auth\AuthenticationException(
                'The provided credentials are incorrect.'
            );
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'token'       => $token,
            'expires_at'  => Carbon::now()->addMinutes(
                config('sanctum.expiration', 60 * 24 * 7)
            ),
            'user'        => $user,
        ];
    }

    public function register(array $data): array
    {
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'status'   => $data['status'] ?? 'active',
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'token'       => $token,
            'expires_at'  => Carbon::now()->addMinutes(
                config('sanctum.expiration', 60 * 24 * 7)
            ),
            'user'        => $user,
        ];
    }

    public function logout(Request $request): void
    {
        $request->user()->currentAccessToken()?->delete();
    }
}
