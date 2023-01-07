<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;
use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TrackCommandTest extends TestCase
{
    protected Product $product;
    protected Http $http;

    public function setUp(): void
    {
        parent::setUp();
        $this->product = app(Product::class);
        $this->http = app(Http::class);
    }

    use RefreshDatabase;

    /** @test */
    public function it_tracks_product_stock()
    {
        $this->seed(RetailerWithProductSeeder::class);
        $this->assertFalse($this->product->first()->inStock());
        $this->http->fake(fn () => ['available' => true, 'price' => 29900]);
        $this->artisan('track');
        $this->assertTrue($this->product->first()->inStock());
    }
}
