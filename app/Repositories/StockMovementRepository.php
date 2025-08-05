<?php

namespace App\Repositories\Eloquent;

use App\Models\StockMovement;
use App\Repositories\Interfaces\StockMovementInterface;
use Illuminate\Support\Collection;

class StockMovementRepository implements StockMovementInterface
{
    public function all(): Collection
    {
        return StockMovement::all();
    }

    public function find(int $id): ?StockMovement
    {
        return StockMovement::find($id);
    }

    public function create(array $data): StockMovement
    {
        return StockMovement::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $stockMovement = $this->find($id);
        return $stockMovement ? $stockMovement->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $stockMovement = $this->find($id);
        return $stockMovement ? $stockMovement->delete() : false;
    }
}
