<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlashSaleItem extends Model
{
    protected $fillable = [
        'flash_sale_id',
        'product_id',
        'flash_price',
        'stock_limit',
        'sold_count',
    ];

    protected $casts = [
        'flash_price' => 'decimal:2',
    ];

    public function flashSale()
    {
        return $this->belongsTo(FlashSale::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Percentage sold, for the progress bar (0-100). Caps at 100.
     */
    public function getSoldPercentAttribute(): int
    {
        if (!$this->stock_limit) {
            return 0;
        }

        return (int) min(100, round(($this->sold_count / $this->stock_limit) * 100));
    }
}
