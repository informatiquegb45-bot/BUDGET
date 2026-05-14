<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WorkOrder;

class DashboardController extends Controller
{
    public function kpis()
    {
        return [
            'work_orders_total' => WorkOrder::count(),
            'work_orders_late' => WorkOrder::whereDate('due_date', '<', now())->whereNotIn('status', ['completed', 'closed'])->count(),
            'work_orders_in_progress' => WorkOrder::where('status', 'in_progress')->count(),
            'work_orders_completed' => WorkOrder::where('status', 'completed')->count(),
        ];
    }
}
