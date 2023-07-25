<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecentlyView extends Model
{
    protected $table = 'recently_view'; // Specify the correct table name

    protected $fillable = ['product_id', 'session_id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
