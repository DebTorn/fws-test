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

    public function getById(int $id)
    {
        return Product::find($id);
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
}
