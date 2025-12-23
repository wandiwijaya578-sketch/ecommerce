<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity'
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Accessor untuk menghitung subtotal (harga produk × quantity)
     */
    public function getSubtotalAttribute()
    {
        // Kalau produk null atau sudah dihapus, return 0
        if (!$this->product) {
            return 0;
        }

        return $this->quantity * $this->product->price;
    }
}