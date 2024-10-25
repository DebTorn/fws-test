<?php

namespace App\Http\Controllers;

use App\Jobs\ImportCSVJob;
use App\Services\Interfaces\IDocumentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class DocumentController extends Controller
{

    public function __construct(private IDocumentService $documentService) {}

    public function import(Request $request)
    {

        if (Redis::get('document:csv:importing')) {
            return response()->json(['message' => 'CSV import already in progress'], 400);
        }

        Redis::set('document:csv:importing', time());
        ImportCSVJob::dispatch($this->documentService);
        return response()->json(['message' => 'CSV import started'], 200);
    }

    public function export(Request $request)
    {
        $result = $this->documentService->export();

        return response()->json($result, 200);
    }
}
