<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Interfaces\AuditLogRepositoryInterface;
use App\Http\Resources\AuditLogResource;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class AuditLogController extends Controller
{
    public function __construct(
        protected AuditLogRepositoryInterface $auditLogRepository
    ) {}

    /**
     * @OA\Get(
     *     path="/api/v1/audit-logs",
     *     operationId="indexAuditLogs",
     *     tags={"AuditLogs"},
     *     summary="List audit logs",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="search", in="query", schema={"type":"string"}),
     *     @OA\Parameter(name="perPage", in="query", schema={"type":"integer"}),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', AuditLog::class);

        $auditLogs = $this->auditLogRepository->index(
            $request->query('search'),
            (int) $request->query('perPage', 15)
        );

        return AuditLogResource::collection($auditLogs)->additional([
            'message' => 'Audit logs retrieved successfully.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/audit-logs/{id}",
     *     operationId="showAuditLog",
     *     tags={"AuditLogs"},
     *     summary="Get audit log",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, schema={"type":"integer"}),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function show(int $id)
    {
        $auditLog = $this->auditLogRepository->getById($id);
        $this->authorize('view', $auditLog);

        return (new AuditLogResource($auditLog))->additional([
            'message' => 'Audit log retrieved successfully.',
        ]);
    }
}
