<?php

namespace App\Repositories\V1\Ticket;

use App\Models\V1\Ticket;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

class TicketRepository implements TicketRepositoryInterface
{
    public function all(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Ticket::query();

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }

        if (!empty($filters['company_code'])) {
            $query->where('company_code', $filters['company_code']);
        }

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['search'])) {
            $query->where('ticket_number', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('subject', 'like', '%' . $filters['search'] . '%');
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function findById(int $id): ?Ticket
    {
        return Ticket::find($id);
    }

    public function findOrFail(int $id): Ticket
    {
        return Ticket::findOrFail($id);
    }

    public function findByCode(string $code): ?Ticket
    {
        return Ticket::where('code', $code)->first();
    }

    public function create(array $data): Ticket
    {
        return Ticket::create($data);
    }

    public function update(Ticket $ticket, array $data): Ticket
    {
        $ticket->update($data);
        return $ticket->fresh();
    }

    public function delete(Ticket $ticket): bool
    {
        return $ticket->delete();
    }

    public function restore(string $code): ?Ticket
    {
        $ticket = Ticket::withTrashed()->where('code', $code)->first();
        if (!$ticket || $ticket->deleted_at === null) {
            return null;
        }
        $ticket->restore();
        return $ticket->fresh();
    }

    public function forceDelete(string $code): bool
    {
        $ticket = Ticket::withTrashed()->where('code', $code)->first();
        if (!$ticket) {
            return false;
        }
        return $ticket->forceDelete();
    }
}
