<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
use Staudenmeir\EloquentJsonRelations\Relations\BelongsToJson;

class Product extends Model
{
    use HasFactory, HasJsonRelationships, Uuid;

    protected $table = 'products';

    protected $fillable = [
        'title',
        'photos',
        'category_id',
        'state',
        'description',
        'color',
        'size',
        'boosted',
        'brand_id',
    ];

    public function user(): BelongsToJson
    {
        return $this->belongsToJson(User::class, 'product_id', 'id');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photos::class, 'product_id', 'id');
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class, 'id', 'category_id');
    }
    public function brand(): HasOne
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }

    public function favorite(): HasMany
    {
        return $this->hasMany(Favorite::class, 'product_id', 'id');
    }
}
