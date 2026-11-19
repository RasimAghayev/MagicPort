<?php

namespace App\Services\V1\Auth;

use Illuminate\Http\Request;

interface AuthServiceInterface
{
    public function login(array $credentials): array;

    public function register(array $data): array;

    public function logout(Request $request): void;
}
