<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Http;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = ['price', 'url', 'sku', 'in_stock'];
    protected $casts = [
        'in_stock' => 'boolean'
    ];

    public function track()
    {
        if ($this->retailer->name = 'Best But') {
            $results = Http::get('http://foo.test')->json();
            $this->update([
                'in_stock' => $results['available'],
                'price' => $results['price']
            ]);
        }
    }

    public function retailer(): BelongsTo
    {
        return $this->belongsTo(Retailer::class);
    }
}
