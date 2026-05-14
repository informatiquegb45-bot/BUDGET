<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMove extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'location_id', 'move_type', 'qty', 'work_order_id'];
}
