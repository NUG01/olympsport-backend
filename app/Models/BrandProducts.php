<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BrandProducts extends Model
{
    use HasFactory;

    protected $table = 'brand_products';

    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'brand_id',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'id', 'product_id');
    }
}
