<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Interfaces\UserInterface;
use Illuminate\Support\Collection;

class UserRepository implements UserInterface
{
    public function all(): Collection
    {
        return User::all();
    }

    public function find(int $id): ?User
    {
        return User::find($id);
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $user = $this->find($id);
        return $user ? $user->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $user = $this->find($id);
        return $user ? $user->delete() : false;
    }
}
