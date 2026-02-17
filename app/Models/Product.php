<?php

namespace App\Models;

use App\Observers\ProductObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([ProductObserver::class])]
class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'status',
    ];

    public function links(): HasMany
    {
        return $this->hasMany(ProductLink::class);
    }

    public function domains(): BelongsToMany
    {
        return $this->belongsToMany(Domain::class)
            ->withPivot(['checkout_url', 'is_active']);
    }
}
