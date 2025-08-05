<?php
namespace App\Repositories\Interfaces;

use App\Models\StockMovement;
use Illuminate\Support\Collection;

interface StockMovementInterface
{
    public function all(): Collection;
    public function find(int $id): ? StockMovement;
    public function create(array $data): StockMovement;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
