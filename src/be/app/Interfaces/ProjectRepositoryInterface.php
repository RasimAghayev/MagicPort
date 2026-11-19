<?php

namespace App\Interfaces;

use App\Models\Project;

interface ProjectRepositoryInterface
{
    public function index($search = null, $perPage = 15);

    public function getByCode(string $code);

    public function store(array $data);

    public function update(array $data, string $code);

    public function delete(string $code);

    public function restore(string $code);

    public function forceDelete(string $code);
}
