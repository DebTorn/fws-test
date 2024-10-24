<?php

namespace App\Services;

use App\Repositories\Interfaces\IProductRepository;
use App\Services\Interfaces\IProductService;

class ProductService implements IProductService
{
    public function __construct(private IProductRepository $productRepository) {}

    public function getAll()
    {
        return $this->productRepository->getAll();
    }

    public function getById(int $id)
    {
        return $this->productRepository->getById($id);
    }

    public function insert(array $data)
    {
        return $this->productRepository->insert($data);
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
