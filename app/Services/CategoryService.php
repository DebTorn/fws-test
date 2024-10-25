<?php

namespace App\Services;

use App\Repositories\Interfaces\ICategoryRepository;
use App\Repositories\Interfaces\IProductRepository;
use App\Services\Interfaces\ICategoryService;
use App\Services\Interfaces\IProductService;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CategoryService implements ICategoryService
{
    public function __construct(private ICategoryRepository $categoryRepository, private IProductService $productService) {}

    public function getAll()
    {
        return $this->categoryRepository->getAll();
    }

    public function getById(int $id)
    {
        return $this->categoryRepository->findById($id);
    }

    public function getByTitle(string $title)
    {
        return $this->categoryRepository->findByTitle($title);
    }

    public function insert(array $data)
    {

        if (empty($data)) {
            throw new \InvalidArgumentException('Data cannot be empty');
        }

        $category = $this->getByTitle($data['title']);

        if (!empty($category)) {
            return null;
        }

        return $this->categoryRepository->insert($data);
    }

    public function attachProduct(int $categoryId, int $productId)
    {

        $category = $this->getById($categoryId);

        if (empty($category)) {
            throw new HttpException(404, 'Category not found');
        }

        $product = $this->productService->getById($productId);

        if (empty($product)) {
            throw new HttpException(404, 'Product not found');
        }


        return $this->categoryRepository->attachProduct($category, $product);
    }
    public function detachProduct(int $categoryId, int $productId)
    {

        $category = $this->getById($categoryId);

        if (empty($category)) {
            throw new HttpException(404, 'Category not found');
        }

        $product = $this->productService->getById($productId);

        if (empty($product)) {
            throw new HttpException(404, 'Product not found');
        }

        return $this->categoryRepository->detachProduct($category, $product);
    }

    public function checkRelation(int $categoryId, int $productId)
    {
        $exists = DB::table('products_categories')
            ->where('category_id', $categoryId)
            ->where('product_id', $productId)
            ->exists();

        if (!$exists) {
            return false;
        }

        return true;
    }
}
