<?php

namespace App\Jobs;

use App\Services\Interfaces\IDocumentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        $this->documentService->import();
    }
}
