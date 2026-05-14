<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return Product::query()->paginate(20);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:products,code'],
            'name' => ['required', 'string', 'max:255'],
            'unit' => ['required', 'string', 'max:20'],
            'type' => ['required', 'in:finished,component,semi_finished'],
        ]);

        return Product::create($data);
    }
}
