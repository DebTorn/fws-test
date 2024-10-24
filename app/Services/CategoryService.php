<?php

namespace App\Services;

use App\Repositories\Interfaces\ICategoryRepository;
use App\Services\Interfaces\ICategoryService;

class CategoryService implements ICategoryService
{
    public function __construct(private ICategoryRepository $categoryRepository) {}

    public function getAll()
    {
        return $this->categoryRepository->getAll();
    }

    public function getById(int $id)
    {
        return $this->categoryRepository->getById($id);
    }

    public function insert(array $data)
    {
        return $this->categoryRepository->insert($data);
    }

    public function update(int $id, array $data)
    {
        return $this->categoryRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->categoryRepository->delete($id);
    }
}
