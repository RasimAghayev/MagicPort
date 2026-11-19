<?php

namespace App\Http\Controllers\V1\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Ticket\StoreTicketRequest;
use App\Http\Requests\V1\Ticket\UpdateTicketRequest;
use App\Http\Resources\V1\Ticket\TicketCollection;
use App\Http\Resources\V1\Ticket\TicketResource;
use App\Services\V1\Ticket\TicketServiceInterface;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function __construct(
        protected TicketServiceInterface $service
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'priority', 'company_code', 'user_id', 'search']);
        $perPage = (int) $request->query('perPage', 15);

        return new TicketCollection($this->service->all($filters, $perPage));
    }

    public function store(StoreTicketRequest $request)
    {
        $ticket = $this->service->create($request->validated());

        return $this->respondCreated(
            new TicketResource($ticket),
            'Ticket created successfully.'
        );
    }

    public function show(string $code)
    {
        $ticket = $this->service->findByCode($code);
        if (!$ticket) {
            return $this->respondError('Ticket not found.', 404);
        }

        return $this->respond(
            new TicketResource($ticket),
            'Ticket retrieved successfully.'
        );
    }

    public function update(UpdateTicketRequest $request, string $code)
    {
        $ticket = $this->service->update($code, $request->validated());

        return $this->respond(
            new TicketResource($ticket),
            'Ticket updated successfully.'
        );
    }

    public function destroy(string $code)
    {
        $deleted = $this->service->delete($code);
        if (!$deleted) {
            return $this->respondError('Ticket not found.', 404);
        }

        return $this->respondDeleted('Ticket deleted successfully.');
    }

    public function restore(string $code)
    {
        $ticket = $this->service->restore($code);
        if (!$ticket) {
            return $this->respondError('Ticket not found.', 404);
        }

        return $this->respond(
            new TicketResource($ticket),
            'Ticket restored successfully.'
        );
    }

    public function forceDelete(string $code)
    {
        $deleted = $this->service->forceDelete($code);
        if (!$deleted) {
            return $this->respondError('Ticket not found.', 404);
        }

        return $this->respondDeleted('Ticket permanently deleted.');
    }
}
