<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    protected $fillable = [
        'default_',
        'canvas_enabled',
        'ie_activex',
        'screen_resolution',
        'ids',
        'updated_at',
    ];
    public $timestamps = false;

    public function cartDetails()
    {
        return $this->hasMany(CartDetail::class, 'cart_id');
    }

    public function add($product, $quantity = 1)
    {
        $cartDetail = $this->cartDetails()->where('product_id', $product->id)->first();

        if ($cartDetail) {
            $cartDetail->quantity += $quantity;
            $cartDetail->total_price = $cartDetail->quantity * $cartDetail->unit_price;
            $cartDetail->save();
        } else {
            $this->cartDetails()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price' => $product->our_price,
                'total_price' => $product->our_price * $quantity,
            ]);
        }
    }
}
