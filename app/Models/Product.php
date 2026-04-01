<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'shop_id',
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'discount_price',
        'stock',
        'is_active',
    ];

    //Casts
    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
    ];

    // Relationships

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
    return $this->hasMany(ProductImage::class);
    }

    public function primaryImage()
    {
    return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function cartitems(){
        return $this->hasMany(CartItem::class);
    }
}
