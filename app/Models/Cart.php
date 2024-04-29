<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';
    protected $fillable = ['user_id','totalPrice'];

    public function cartProduct()
    {
        return $this->hasMany(Cart_Products::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
