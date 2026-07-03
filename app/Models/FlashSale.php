<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlashSale extends Model
{
    protected $fillable = [
        'title',
        'starts_at',
        'ends_at',
        'is_active',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function items()
    {
        return $this->hasMany(FlashSaleItem::class);
    }

    /**
     * The currently running flash sale (if any), with product data eager-loaded.
     * Returns null if no sale is currently active.
     */
    public static function current()
    {
        return static::query()
            ->where('is_active', true)
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now())
            ->with(['items.product.primaryImage'])
            ->first();
    }
}
