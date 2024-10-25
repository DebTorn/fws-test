<?php

namespace App\Services;

use App\Repositories\Interfaces\IProductRepository;
use App\Services\Interfaces\IProductService;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ProductService implements IProductService
{
    public function __construct(private IProductRepository $productRepository) {}

    public function getAll()
    {
        return $this->productRepository->getAll();
    }

    public function getById(int $id)
    {
        return $this->productRepository->findById($id);
    }

    public function getByTitle(string $title)
    {
        return $this->productRepository->findByTitle($title);
    }

    public function insert(array $data)
    {
        if (empty($data)) {
            throw new \InvalidArgumentException('Data cannot be empty');
        }

        $product = $this->getByTitle($data['title']);

        if (!empty($product)) {
            return [
                'exists' => true,
                'product' => $product
            ];
        }

        $insertedProduct = $this->productRepository->insert($data);

        return [
            'exists' => false,
            'product' => $insertedProduct
        ];
    }

    public function update(int $id, array $data)
    {
        return $this->productRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->productRepository->delete($id);
    }

    public function getProductCategoryIds(int $productId)
    {
        return $this->productRepository->findProductCategoryIds($productId);
    }
}
