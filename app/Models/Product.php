<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'slug',
        'price',
        'special_price',
        'special_price_from',
        'special_price_to',
        'is_active'
    ];

    protected $hidden = [
        'pivot',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_products');
    }
}
