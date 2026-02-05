<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductLink extends Model
{
    /** @use HasFactory<\Database\Factories\ProductLinkFactory> */
    use HasFactory;

    protected $fillable = [
        'product_id',
        'url',
        'type',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
