<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Interfaces\ICategoryRepository;

class CategoryRepository implements ICategoryRepository
{
    public function getAll()
    {
        return Category::all();
    }

    public function getById(int $id)
    {
        return Category::find($id);
    }

    public function insert(array $data)
    {
        return Category::create($data);
    }

    public function update(int $id, array $data)
    {
        return Category::find($id)->update($data);
    }

    public function delete(int $id)
    {
        return Category::destroy($id);
    }
}
