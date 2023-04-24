<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class Brand extends Model
{
    use HasFactory, HasJsonRelationships;

    protected $table = 'brands';

    public $timestamps = false;
    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'product_id',
    ];

    protected $casts = [
        'parent_id' => 'json',
        'product_id' => 'json',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function categories(): \Staudenmeir\EloquentJsonRelations\Relations\BelongsToJson
    {
        return $this->belongsToJson(Category::class, 'category_id', 'id');
    }

    public function products(): \Staudenmeir\EloquentJsonRelations\Relations\HasManyJson
    {
        return $this->hasManyJson(Product::class, 'id', 'product_id');
    }
}
