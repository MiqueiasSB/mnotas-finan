<?php

namespace App\Repositories\Eloquent;

use App\Models\Transacao;
use App\Repositories\Interfaces\TransactionInterface;
use Illuminate\Support\Collection;

class TransactionRepository implements TransactionInterface
{
    public function all(): Collection
    {
        return Transacao::all();
    }

    public function find(int $id): ?Transacao
    {
        return Transacao::find($id);
    }

    public function create(array $data): Transacao
    {
        return Transacao::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $transacao = $this->find($id);
        return $transacao ? $transacao->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $transacao = $this->find($id);
        return $transacao ? $transacao->delete() : false;
    }
}
