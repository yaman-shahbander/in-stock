<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TrackCommandTest extends TestCase
{
    protected Product $product;
    protected Retailer $retailer;
    protected Stock $stock;
    protected Http $http;

    public function setUp(): void
    {
        parent::setUp();
        $this->product = app(Product::class);
        $this->retailer = app(Retailer::class);
        $this->stock = app(Stock::class);
        $this->http = app(Http::class);
    }

    use RefreshDatabase;

    /** @test */
    public function it_tracks_product_stock()
    {
        $switch = $this->product->create(['name' => 'Nintendo Switch']);
        $bestBuy = $this->retailer->create(['name' => 'Best Buy']);
        $this->assertFalse($switch->inStock());
        $stock = $this->stock;
        $stock->price = 1000;
        $stock->url = 'http://foo.com';
        $stock->sku = '12345';
        $stock->in_stock = false;
        $bestBuy->addStock($switch, $stock);
        $this->assertFalse($stock->fresh()->in_stock);
        $this->http->fake(function () {
            return [
                'available' => true,
                'price' => 29900
            ];
        });
        $this->artisan('track');
        $this->assertTrue($stock->fresh()->in_stock);
    }
}
