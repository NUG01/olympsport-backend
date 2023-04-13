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
        'parent_id',
    ];

    protected $casts = [
        'parent_id' => 'json',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category(): \Staudenmeir\EloquentJsonRelations\Relations\BelongsToJson
    {
        return $this->belongsToJson(Category::class, 'parent_id', 'id');
    }
}
