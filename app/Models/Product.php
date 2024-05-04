<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'imageCover',
        'price',
        'color',
        'quantity',
        'status',
        'sub_category_id',
        'category_id',
        'brand_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function wishlist()
    {
        return $this->belongsTo(Wishlist::class);
    }
}
