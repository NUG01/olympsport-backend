<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class Brand extends Model
{
    use HasFactory, HasJsonRelationships;


    public $timestamps = false;
    protected $fillable = [
        'name',
        'slug',
        'category_id',
    ];

    protected $casts = [
        'category_id' => 'json',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function categories(): \Staudenmeir\EloquentJsonRelations\Relations\BelongsToJson
    {
        return $this->belongsToJson(Category::class, 'category_id', 'id');
    }

    public function products(): HasMany
    {
        return $this->HasMany(Product::class);
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($brand) {
            $brand->products->each(function ($cat) {
                $cat->delete();
            });
        });
    }
}
