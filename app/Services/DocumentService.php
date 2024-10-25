<?php

namespace App\Services;

use App\Jobs\ImportCSVChunkJob;
use App\Services\Interfaces\ICategoryService;
use App\Services\Interfaces\IDocumentService;
use App\Services\Interfaces\IProductService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DocumentService implements IDocumentService
{

    private array $categoryIndexes = [2, 3, 4];

    public function __construct(
        private ICategoryService $categoryService,
        private IProductService $productService
    ) {}

    /**
     * Import products from CSV file
     */
    public function import()
    {

        ini_set('memory_limit', '1024M');

        Log::info('CSV file import started');

        if (!Storage::disk('private')->exists(config('app.csv_file_name'))) {
            throw new \Exception('CSV file not found.');
        }

        $csvContent = Storage::disk('private')->get(config('app.csv_file_name'));
        $rows = array_map('str_getcsv', explode("\n", $csvContent));
        array_shift($rows);

        $chunkSize = 100;
        $chunks = array_chunk($rows, $chunkSize);
        $maxChunks = count($chunks);
        $chunksCount = 1;

        foreach ($chunks as $chunk) {
            ImportCSVChunkJob::dispatch($chunk, $this->categoryIndexes, $this->categoryService, $this->productService, $chunksCount, $maxChunks);
            $chunksCount++;
        }

        return [
            'message' => 'CSV file import started'
        ];
    }


    /**
     * Export products to XML file
     */
    public function export() {}
}