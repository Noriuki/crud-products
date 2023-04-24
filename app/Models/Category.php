<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'slug'
    ];

    protected $hidden = [
        'pivot',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_products');
    }
}
