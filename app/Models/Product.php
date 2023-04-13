<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class Product extends Model
{
    use HasFactory, HasJsonRelationships, Uuid;

    protected $table = 'products';

    protected $fillable = [
        'title',
        'photos',
        'category',
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

    public static function photos(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return (new Product)->hasMany(Photos::class, 'product_id', 'id');
    }
}
