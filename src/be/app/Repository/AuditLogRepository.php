<?php

namespace App\Repository;

use App\Interfaces\AuditLogRepositoryInterface;
use App\Models\AuditLog;

class AuditLogRepository implements AuditLogRepositoryInterface
{
    public function index($search = null, $perPage = 15)
    {
        $query = AuditLog::query()->with('user');

        if (!empty($search)) {
            $query->where('action', 'like', "%{$search}%");
        }

        return $query->orderByDesc('created_at')->paginate((int) $perPage);
    }

    public function getById(int $id)
    {
        return AuditLog::findOrFail($id);
    }
}
