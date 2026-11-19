<?php

namespace App\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function index($search = null, $perPage = 15);

    public function getById(int $id);

    public function store(array $data);

    public function update(array $data, int $id);

    public function delete(int $id);

    public function restore(int $id);

    public function forceDelete(int $id);
}
