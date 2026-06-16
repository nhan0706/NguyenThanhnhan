<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    
    protected $primaryKey = 'id';

    protected $fillable = [
        'proname',
        'cateid',
        'brandid',
        'slug',
        'price',
        'image',
        'status',
        'description'
    ];

    // Cấu hình Quan hệ với Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'cateid', 'cateid');
    }

    // Cấu hình Quan hệ với Brand
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brandid', 'id');
    }
}
