<?php

namespace App\Repositories\Eloquent;

use App\Models\Cliente;
use App\Repositories\Interfaces\ClientInterface;
use Illuminate\Support\Collection;

class ClientRepository implements ClientInterface
{
    public function all(): Collection
    {
        return Cliente::all();
    }

    public function find(int $id): ?Cliente
    {
        return Cliente::find($id);
    }

    public function create(array $data): Cliente
    {
        return Cliente::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $cliente = $this->find($id);
        return $cliente ? $cliente->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $cliente = $this->find($id);
        return $cliente ? $cliente->delete() : false;
    }
}
