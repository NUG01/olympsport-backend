<?php

namespace App\Models;

use App\Observers\CategoryObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;


class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    // public $translatable = ['name'];

    protected array $observers = [
        Category::class => [CategoryObserver::class],
    ];

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'slug',
        'parent_id',
    ];

    protected $casts = [
        'name' => 'json',
    ];



    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')->with('parent');
    }

    public function products(): HasManyThrough
    {
        return $this->hasManyThrough(Product::class, Category::class, 'parent_id', 'category_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($category) {
            $category->products->each(function ($cat) {
                $cat->delete();
            });

            $category->children->each(function ($cat) {
                $cat->delete();
            });
        });
    }
}
