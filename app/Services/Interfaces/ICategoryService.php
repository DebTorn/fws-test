<?php

namespace App\Services\Interfaces;

interface ICategoryService
{
    public function getAll();
    public function getById(int $id);
    public function getByTitle(string $title);
    public function insert(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function attachProduct(int $categoryId, int $productId);
    public function detachProduct(int $categoryId, int $productId);
    public function checkRelation(int $categoryId, int $productId);
}
