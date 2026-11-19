<?php

namespace App\Http\Resources\V1\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TokenResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'access_token' => $this->token,
            'token_type'   => 'Bearer',
            'expires_at'   => $this->expires_at?->toISOString(),
            'user'         => new \App\Http\Resources\V1\User\UserResource($this->user),
        ];
    }
}
