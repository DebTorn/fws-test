<?php

use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

Route::post('import', [DocumentController::class, 'import']);
Route::get('export', [DocumentController::class, 'export']);
