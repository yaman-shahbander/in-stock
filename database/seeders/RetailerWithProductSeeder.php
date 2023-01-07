<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RetailerWithProductSeeder extends Seeder
{
    public function __construct(protected Product $product, protected Retailer $retailer, protected Stock $stock)
    {
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $switch = $this->product->create(['name' => 'Nintendo Switch']);
        $bestBuy = $this->retailer->create(['name' => 'Best Buy']);
        $stock = $this->stock;
        $stock->price = 1000;
        $stock->url = 'http://foo.com';
        $stock->sku = '12345';
        $stock->in_stock = false;
        $bestBuy->addStock($switch, $stock);
    }
}
