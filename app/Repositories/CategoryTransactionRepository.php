<?php

namespace App\Repositories\Eloquent;

use App\Models\CategoriaTransacao as CategoryTransaction;
use App\Repositories\Interfaces\CategoryTransactionInterface;
use Illuminate\Support\Collection;

class CategoryTransactionRepository implements CategoryTransactionInterface
{
    public function all(): Collection
    {
        return CategoryTransaction::all();
    }

    public function find(int $id): ?CategoryTransaction
    {
        return CategoryTransaction::find($id);
    }

    public function create(array $data): CategoryTransaction
    {
        return CategoryTransaction::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $categoryTransaction = $this->find($id);
        return $categoryTransaction ? $categoryTransaction->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $categoryTransaction = $this->find($id);
        return $categoryTransaction ? $categoryTransaction->delete() : false;
    }
}
