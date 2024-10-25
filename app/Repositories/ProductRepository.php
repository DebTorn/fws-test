<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\IProductRepository;

class ProductRepository implements IProductRepository
{
    public function getAll()
    {
        return Product::all();
    }

    public function findById(int $id)
    {
        return Product::find($id);
    }

    public function findByTitle(string $title)
    {
        return Product::where('title', $title)->first();
    }

    public function insert(array $data)
    {
        return Product::create($data);
    }

    public function update(int $id, array $data)
    {
        return Product::find($id)->update($data);
    }

    public function delete(int $id)
    {
        return Product::destroy($id);
    }

    public function findProductCategoryIds(int $productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            return [];
        }

        return $product->categories->pluck('id')->toArray();
    }
}
