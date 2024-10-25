<?php

namespace App\Http\Controllers;

use App\Jobs\ImportCSVJob;
use App\Services\Interfaces\IDocumentService;
use Illuminate\Http\Request;

class ImportController extends Controller
{

    public function __construct(private IDocumentService $documentService) {}

    public function import(Request $request)
    {
        ImportCSVJob::dispatch($this->documentService);
        return response()->json(['message' => 'CSV import started'], 200);
    }
}