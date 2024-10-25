<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Product;
use App\Repositories\Interfaces\ICategoryRepository;

use function Symfony\Component\String\b;

class CategoryRepository implements ICategoryRepository
{
    public function getAll()
    {
        return Category::all();
    }

    public function findById(int $id)
    {
        return Category::find($id);
    }

    public function findByTitle(string $title)
    {
        return Category::where('title', $title)->first();
    }

    public function insert(array $data)
    {
        return Category::create($data);
    }

    public function attachProduct(Category $category, Product $product)
    {
        $category->products()->attach($product->id);
    }

    public function detachProduct(Category $category, Product $product)
    {
        $category->products()->detach($product->id);
    }
}
