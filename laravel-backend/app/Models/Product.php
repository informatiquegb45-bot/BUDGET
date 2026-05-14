<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'unit', 'type'];

    public function bomComponents()
    {
        return $this->hasMany(BomItem::class, 'parent_product_id');
    }

    public function operations()
    {
        return $this->hasMany(Operation::class);
    }
}
