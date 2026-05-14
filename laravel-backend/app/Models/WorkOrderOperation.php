<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderOperation extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_order_id', 'operation_id', 'planned_start', 'planned_end',
        'actual_start', 'actual_end', 'status'
    ];
}
