<?php

namespace App\Repository;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function index($search = null, $perPage = 15)
    {
        $query = User::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('name')->paginate((int) $perPage);
    }

    public function getById(int $id)
    {
        return User::findOrFail($id);
    }

    public function store(array $data)
    {
        return User::create($data);
    }

    public function update(array $data, int $id)
    {
        $user = User::findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function delete(int $id)
    {
        $user = User::findOrFail($id);
        return $user->delete();
    }

    public function restore(int $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        return $user->restore();
    }

    public function forceDelete(int $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        return $user->forceDelete();
    }
}
