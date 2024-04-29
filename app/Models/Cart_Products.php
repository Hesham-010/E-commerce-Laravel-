<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart_Products extends Model
{
    use HasFactory;

    protected $table = 'cart_products';
    protected $fillable = ['cart_id', 'product_id', 'quantity','unitPrice'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}
