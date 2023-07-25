<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['sku', 'image', 'name', 'description', 'retail_price', 'our_price'];

    // Define the relationship with RecentlyView
    public function recentlyViewed()
    {
        return $this->hasMany(RecentlyView::class, 'product_id');
    }
    public function cartDetails()
    {
        return $this->hasMany(CartDetail::class, 'product_id');
    }

    public function cartProducts()
    {
        return $this->hasMany(CartProduct::class, 'product_id');
    }
}
