<?php

namespace App\Services\Interfaces;

interface IProductService
{
    public function getAll();
    public function getById(int $id);
    public function getByTitle(string $title);
    public function insert(array $data);
    public function update(int $id, array $data);
    public function getProductCategoryIds(int $productId);
}
