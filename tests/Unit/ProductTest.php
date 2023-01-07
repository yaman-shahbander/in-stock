<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    protected Product $product;
    protected Retailer $retailer;
    protected Stock $stock;

    public function setUp(): void
    {
        parent::setUp();
        $this->product = app(Product::class);
        $this->retailer = app(Retailer::class);
        $this->stock = app(Stock::class);
    }

    use RefreshDatabase;
    /** @test */
    public function it_checks_stock_for_products_at_retailers()
    {
        $switch = $this->product->create(['name' => 'Nintendo Switch']);
        $bestBuy = $this->retailer->create(['name' => 'Best Buy']);
        $this->assertFalse($switch->inStock());
        $stock = $this->stock;
        $stock->price = 1000;
        $stock->url = 'http://foo.com';
        $stock->sku = '12345';
        $stock->in_stock = true;
        $bestBuy->addStock($switch, $stock);
        $this->assertTrue($switch->inStock());
    }
}
