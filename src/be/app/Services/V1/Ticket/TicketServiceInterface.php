<?php

namespace App\Services\V1\Ticket;

use App\Models\V1\Ticket;
use App\Repositories\V1\Ticket\TicketRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

interface TicketServiceInterface
{
    public function all(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function findByCode(string $code): ?Ticket;

    public function create(array $data): Ticket;

    public function update(string $code, array $data): Ticket;

    public function delete(string $code): bool;

    public function restore(string $code): ?Ticket;

    public function forceDelete(string $code): bool;
}
