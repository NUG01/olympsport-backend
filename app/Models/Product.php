<?php

namespace App\Models;

use App\Traits\Uuid;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

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
    ];

    public function user(): \Staudenmeir\EloquentJsonRelations\Relations\BelongsToJson
    {
        return $this->belongsToJson(User::class, 'product_id', 'id');
    }

    public function photos(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Photos::class, 'product_id', 'id');
    }

    public function categories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Category::class, 'id', 'category_id');
    }
    public function brand(): BelongsTo
    {
        return $this->BelongsTo(Brand::class);
    }
}
