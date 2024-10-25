<?php

namespace App\Jobs;

use App\Services\Interfaces\ICategoryService;
use App\Services\Interfaces\IProductService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ImportCSVChunkJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $chunk;
    protected array $categoryIndexes;
    protected int $chunksCount;
    protected int $maxChunks;
    private ICategoryService $categoryService;
    private IProductService $productService;

    public function __construct(
        array $chunk,
        array $categoryIndexes,
        ICategoryService $categoryService,
        IProductService $productService,
        int $chunksCount,
        int $maxChunks
    ) {
        $this->chunk = $chunk;
        $this->chunksCount = $chunksCount;
        $this->maxChunks = $maxChunks;
        $this->categoryIndexes = $categoryIndexes;
        $this->categoryService = $categoryService;
        $this->productService = $productService;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("Chunk #" . $this->chunksCount . " started");
        $this->processRows($this->chunk);
        Log::info("Chunk #" . $this->chunksCount . " ended");

        if ($this->chunksCount == $this->maxChunks) {
            Log::info('All chunks dispatched! CSV file import finished');
        }
    }

    public function processRows(array $rows)
    {
        foreach ($rows as $row) {

            if (empty($row) || (is_array($row) && (!isset($row[0]) || !isset($row[1])))) {
                continue;
            }

            $prodctData = [
                'title' => $row[0],
                'gross_price' => $row[1]
            ];

            $insertedProduct = $this->productService->insert($prodctData);

            //If product exists
            if ($insertedProduct['exists']) {

                //If the price is different, update the price
                if ($insertedProduct['product']->gross_price != $row[1]) {
                    $prodctData = [
                        'gross_price' => $row[1]
                    ];

                    $insertedProduct = $this->productService->update($insertedProduct['product']->id, $prodctData);
                }

                //Check if categories exists
                $currentCategoryIds = $this->productService->getProductCategoryIds($insertedProduct['product']->id);
                $newCategoryIds = [];

                foreach ($this->categoryIndexes as $index) {
                    if (isset($row[$index])) {
                        $category = $this->categoryService->getByTitle($row[$index]);

                        //If category does not exist, insert it
                        if (empty($category)) {
                            $categoryData = [
                                'title' => $row[$index]
                            ];

                            $insertedCategory = $this->categoryService->insert($categoryData);

                            //Attach product to category
                            $this->categoryService->attachProduct($insertedCategory['id'], $insertedProduct['id']);

                            $newCategoryIds[] = $insertedCategory->id;
                        } else {
                            //Check if product is already attached to category
                            if (!$this->categoryService->checkRelation($category->id, $insertedProduct['product']->id)) {
                                $this->categoryService->attachProduct($category->id, $insertedProduct['product']->id);
                            }

                            $newCategoryIds[] = $category->id;
                        }
                    }
                }

                //Detach product from categories that are not in the new list
                $categoriesToRemove = array_diff($currentCategoryIds, $newCategoryIds);
                foreach ($categoriesToRemove as $categoryId) {
                    $this->categoryService->detachProduct($categoryId, $insertedProduct['product']->id);
                }
            } else { //If product not exists

                //Insert product
                $insertedProduct = $this->productService->insert($prodctData);

                foreach ($this->categoryIndexes as $index) {
                    if (isset($row[$index])) {
                        $category = $this->categoryService->getByTitle($row[$index]);

                        //If category does not exist, insert it
                        if (empty($category)) {
                            $categoryData = [
                                'title' => $row[$index]
                            ];

                            $insertedCategory = $this->categoryService->insert($categoryData);

                            //Attach product to category
                            $this->categoryService->attachProduct($insertedCategory['id'], $insertedProduct['product']->id);
                        } else {
                            //Attach product to category
                            $this->categoryService->attachProduct($category->id, $insertedProduct['product']->id);
                        }
                    }
                }
            }
        }
    }
}
