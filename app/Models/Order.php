<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'order_status',
        'totalPrice',
        'totalPriceAfterDiscount',
        'shipping_address',
        'order_date',
        'isPaid',
        'postalCode',
        'user_id',
        'coupon_id',
    ];

    public function orderProduct()
    {
        return $this->hasMany(Order_Products::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
