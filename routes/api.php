<?php

use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')
    ->prefix('v1')
    ->group(function() {
        Route::apiResource('customers', CustomerController::class);
        Route::apiResource('invoices', InvoiceController::class);

        Route::post('invoices/bulk', ['uses' => 'InvoiceController@bulkStore']);
});