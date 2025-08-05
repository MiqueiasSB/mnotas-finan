<?php
namespace App\Repositories\Interfaces;

use App\Models\CategoriaTransacao;
use Illuminate\Support\Collection;

interface CategoryTransactionInterface
{
    public function all(): Collection;
    public function find(int $id): ? CategoriaTransacao;
    public function create(array $data): CategoriaTransacao;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
