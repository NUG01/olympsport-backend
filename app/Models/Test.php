<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Test extends Model
{

    use HasFactory, HasTranslations;


    public $translatable = ['name'];

    protected array $observers = [
        Category::class => [CategoryObserver::class],
    ];

    public $timestamps = false;

    protected $guarded = [
        'id',

    ];

    protected $casts = [
        'name' => 'json',
    ];
}
