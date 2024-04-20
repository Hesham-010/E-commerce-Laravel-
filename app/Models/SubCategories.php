<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class SubCategories extends Model
{
    use HasFactory;

    protected $fillable =['name','status','category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeBySubcategoryNameOrCategoryTitle($query, $keyword)
    {
        return $query->where('name', 'like', '%' . $keyword . '%')
            ->orWhereHas('category', function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%');
            });
    }
}
