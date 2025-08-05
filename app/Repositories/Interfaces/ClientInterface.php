<?php
namespace App\Repositories\Interfaces;

use App\Models\Cliente;
use Illuminate\Support\Collection;

interface ClientInterface
{
    public function all(): Collection;
    public function find(int $id): ?Cliente;
    public function create(array $data): Cliente;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
