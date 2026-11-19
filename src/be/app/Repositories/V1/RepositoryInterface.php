<?php

namespace App\Repositories\V1;

interface RepositoryInterface
{
    public function all(array $filters = [], int $perPage = 15): \Illuminate\Pagination\LengthAwarePaginator;

    public function findById(int $id): mixed;

    public function findOrFail(int $id): mixed;
}
