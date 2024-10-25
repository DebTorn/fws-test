<?php

namespace App\Jobs;

use App\Services\Interfaces\IDocumentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class ImportCSVJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private IDocumentService $documentService;

    public function __construct(IDocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

    public function handle()
    {
        try {
            $this->documentService->import();
        } catch (\Exception $e) {
            Log::error($e);

            Redis::del('document:csv:importing');
            Redis::del('document:csv:remaining_chunks');
        }
    }
}
