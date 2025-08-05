<?php
namespace App\Repositories\Interfaces;

use App\Models\Transacao;
use Illuminate\Support\Collection;

interface TransactionInterface
{
    public function all(): Collection;
    public function find(int $id): ? Transacao;
    public function create(array $data): Transacao;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
