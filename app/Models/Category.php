<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['title','status','image'];

    protected $casts = [
        'category_id' => 'uuid',
    ];

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = ucfirst($value);
    }
    public function subcategories()
    {
        return $this->hasMany(SubCategories::class);
    }

}
