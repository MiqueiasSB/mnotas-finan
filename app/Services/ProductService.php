<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductInterface;

class ProductService
{
    protected ProductInterface $productRepository;

    public function __construct(ProductInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function listAll()
    {
        return $this->productRepository->all();
    }

    public function findById(int $id)
    {
        return $this->productRepository->find($id);
    }

    public function create(array $data)
    {
        // Aqui você pode adicionar validações, regras de negócio, etc.
        return $this->productRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->productRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->productRepository->delete($id);
    }
}

