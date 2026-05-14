<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\StockLocation;
use App\Models\WorkCenter;
use Illuminate\Database\Seeder;

class GpaoSeeder extends Seeder
{
    public function run(): void
    {
        Product::create(['code' => 'FIN-1000', 'name' => 'Produit fini A', 'unit' => 'pcs', 'type' => 'finished']);
        Product::create(['code' => 'CMP-0001', 'name' => 'Composant X', 'unit' => 'pcs', 'type' => 'component']);

        WorkCenter::create(['code' => 'WC-ASB', 'name' => 'Assemblage', 'capacity' => 2]);
        StockLocation::create(['code' => 'MAIN', 'name' => 'Magasin principal']);
    }
}
