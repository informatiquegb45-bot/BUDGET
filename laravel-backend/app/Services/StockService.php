<?php

namespace App\Services;

use App\Models\StockMove;

class StockService
{
    public function reserveComponent(int $productId, int $locationId, float $qty, ?int $workOrderId = null): void
    {
        StockMove::create([
            'product_id' => $productId,
            'location_id' => $locationId,
            'move_type' => 'consume',
            'qty' => $qty,
            'work_order_id' => $workOrderId,
        ]);
    }

    public function receiveFinishedGood(int $productId, int $locationId, float $qty, ?int $workOrderId = null): void
    {
        StockMove::create([
            'product_id' => $productId,
            'location_id' => $locationId,
            'move_type' => 'produce',
            'qty' => $qty,
            'work_order_id' => $workOrderId,
        ]);
    }
}
