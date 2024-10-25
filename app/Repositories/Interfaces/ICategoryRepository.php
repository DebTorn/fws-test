<?php

namespace App\Repositories\Interfaces;

use App\Models\Category;
use App\Models\Product;

interface ICategoryRepository
{
    public function getAll();
    public function findById(int $id);
    public function findByTitle(string $title);
    public function insert(array $data);
    public function attachProduct(Category $category, Product $product);
    public function detachProduct(Category $category, Product $product);
}
