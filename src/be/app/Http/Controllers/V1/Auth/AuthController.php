<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\LoginRequest;
use App\Http\Requests\V1\Auth\RegisterRequest;
use App\Http\Resources\V1\Auth\TokenResource;
use App\Services\V1\Auth\AuthServiceInterface;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        protected AuthServiceInterface $service
    ) {}

    public function login(LoginRequest $request): TokenResource
    {
        $token = $this->service->login($request->validated());

        return new TokenResource($token);
    }

    public function register(RegisterRequest $request): TokenResource
    {
        $token = $this->service->register($request->validated());

        return new TokenResource($token);
    }

    public function logout(Request $request)
    {
        $this->service->logout($request);

        return $this->respondDeleted('Logged out successfully.');
    }

    public function me(Request $request)
    {
        return $this->respond(
            new \App\Http\Resources\V1\User\UserResource($request->user()),
            'Current user retrieved successfully.'
        );
    }
}
