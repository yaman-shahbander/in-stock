<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function it_checks_stock_for_products_at_retailers()
    {
        $switch = Product::create(['name' => 'Nintendo Switch']);
        $bestBuy = Retailer::create(['name' => 'Best Buy']);
        $this->assertFalse($switch->inStock());
        $stock = app(Stock::class);
        $stock->price = 1000;
        $stock->url = 'http://foo.com';
        $stock->sku = '12345';
        $stock->in_stock = true;
        $bestBuy->addStock($switch, $stock);
        $this->assertTrue($switch->inStock());
    }
}
