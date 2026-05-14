<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWorkOrderRequest;
use App\Models\WorkOrder;
use App\Services\WorkOrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WorkOrderController extends Controller
{
    public function __construct(private readonly WorkOrderService $service)
    {
    }

    public function index()
    {
        return WorkOrder::query()->latest()->paginate(20);
    }

    public function store(StoreWorkOrderRequest $request)
    {
        $data = $request->validated();
        $data['number'] = 'OF-' . now()->format('Ymd') . '-' . Str::padLeft((string) random_int(1, 9999), 4, '0');
        $data['status'] = 'draft';
        $data['qty_done'] = 0;

        return WorkOrder::create($data);
    }

    public function release(WorkOrder $workOrder)
    {
        return $this->service->release($workOrder);
    }

    public function reportProduction(Request $request, WorkOrder $workOrder)
    {
        $data = $request->validate([
            'qty_done' => ['required', 'numeric', 'min:0.01'],
            'output_location_id' => ['required', 'exists:stock_locations,id'],
        ]);

        return $this->service->reportProduction(
            $workOrder,
            (float) $data['qty_done'],
            (int) $data['output_location_id']
        );
    }
}
