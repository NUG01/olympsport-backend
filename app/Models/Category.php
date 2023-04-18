<?php

namespace App\Models;

use App\Observers\CategoryObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;


class Category extends Model
{
    use HasFactory, HasJsonRelationships;

    protected $table = 'categories';

    protected array $observers = [
        Category::class => [CategoryObserver::class],
    ];

    protected $with = ['children'];

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'slug',
        'parent_id',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
}
