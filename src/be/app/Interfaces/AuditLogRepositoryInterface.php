<?php

namespace App\Interfaces;

use App\Models\AuditLog;

interface AuditLogRepositoryInterface
{
    public function index($search = null, $perPage = 15);

    public function getById(int $id);
}
