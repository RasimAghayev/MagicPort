<?php

namespace App\Repositories\V1\Ticket;

use App\Models\V1\Ticket;
use App\Repositories\V1\RepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

interface TicketRepositoryInterface extends RepositoryInterface
{
    public function all(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function findByCode(string $code): ?Ticket;

    public function create(array $data): Ticket;

    public function update(Ticket $ticket, array $data): Ticket;

    public function delete(Ticket $ticket): bool;

    public function restore(string $code): ?Ticket;

    public function forceDelete(string $code): bool;
}
