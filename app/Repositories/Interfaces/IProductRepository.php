<?php

namespace App\Repositories\Interfaces;

interface IProductRepository
{
    public function getAll();
    public function findById(int $id);
    public function findByTitle(string $title);
    public function insert(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function findProductCategoryIds(int $productId);
}
