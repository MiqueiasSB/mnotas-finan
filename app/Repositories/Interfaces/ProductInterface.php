<?php
namespace App\Repositories\Interfaces;

use App\Models\Product;
use Illuminate\Support\Collection;

interface ProductInterface
{
    public function all(): Collection;
    public function find(int $id): ?Product;
    public function create(array $data): Product;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
