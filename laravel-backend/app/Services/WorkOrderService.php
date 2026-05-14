<?php

namespace App\Services;

use App\Models\Operation;
use App\Models\WorkOrder;
use App\Models\WorkOrderOperation;
use Illuminate\Support\Facades\DB;

class WorkOrderService
{
    public function __construct(private readonly StockService $stockService)
    {
    }

    public function release(WorkOrder $workOrder): WorkOrder
    {
        return DB::transaction(function () use ($workOrder) {
            $workOrder->update(['status' => 'released']);

            $operations = Operation::query()->where('product_id', $workOrder->product_id)->get();
            foreach ($operations as $operation) {
                WorkOrderOperation::create([
                    'work_order_id' => $workOrder->id,
                    'operation_id' => $operation->id,
                    'status' => 'planned',
                ]);
            }

            return $workOrder->refresh();
        });
    }

    public function reportProduction(WorkOrder $workOrder, float $qtyDone, int $outputLocationId): WorkOrder
    {
        return DB::transaction(function () use ($workOrder, $qtyDone, $outputLocationId) {
            $newTotal = $workOrder->qty_done + $qtyDone;
            $status = $newTotal >= $workOrder->qty_planned ? 'completed' : 'in_progress';

            $workOrder->update([
                'qty_done' => $newTotal,
                'status' => $status,
            ]);

            $this->stockService->receiveFinishedGood(
                $workOrder->product_id,
                $outputLocationId,
                $qtyDone,
                $workOrder->id
            );

            return $workOrder->refresh();
        });
    }
}
