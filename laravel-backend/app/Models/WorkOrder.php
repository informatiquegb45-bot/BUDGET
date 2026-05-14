<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    use HasFactory;

    protected $fillable = ['number', 'product_id', 'qty_planned', 'qty_done', 'status', 'due_date'];

    protected $casts = ['due_date' => 'date'];
}
