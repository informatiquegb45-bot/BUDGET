<?php

use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\WorkOrderController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('products', ProductController::class);
    Route::apiResource('work-orders', WorkOrderController::class);

    Route::post('work-orders/{workOrder}/release', [WorkOrderController::class, 'release']);
    Route::post('work-orders/{workOrder}/report', [WorkOrderController::class, 'reportProduction']);
    Route::get('dashboard/kpis', [DashboardController::class, 'kpis']);
});
