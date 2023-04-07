<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;


class Category extends Model
{
    use HasFactory, HasJsonRelationships;

    protected $table = 'categories';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
    ];

    protected $casts = [
        'parent_id' => 'json'
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function children(): \Staudenmeir\EloquentJsonRelations\Relations\HasManyJson
    {
        return $this->hasManyJson(Category::class, 'parent_id');
    }
}
