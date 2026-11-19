<?php

namespace App\Services\V1\Ticket;

use App\Models\V1\Ticket;
use App\Repositories\V1\Ticket\TicketRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

class TicketService implements TicketServiceInterface
{
    public function __construct(
        protected TicketRepositoryInterface $repository
    ) {}

    public function all(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->all($filters, $perPage);
    }

    public function findByCode(string $code): ?Ticket
    {
        return $this->repository->findByCode($code);
    }

    public function create(array $data): Ticket
    {
        return $this->repository->create($data);
    }

    public function update(string $code, array $data): Ticket
    {
        $ticket = $this->repository->findByCode($code);
        if (!$ticket) {
            throw new ModelNotFoundException("Ticket with code {$code} not found.");
        }
        return $this->repository->update($ticket, $data);
    }

    public function delete(string $code): bool
    {
        $ticket = $this->repository->findByCode($code);
        if (!$ticket) {
            return false;
        }
        return $this->repository->delete($ticket);
    }

    public function restore(string $code): ?Ticket
    {
        return $this->repository->restore($code);
    }

    public function forceDelete(string $code): bool
    {
        return $this->repository->forceDelete($code);
    }
}
