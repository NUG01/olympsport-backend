<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    use HasFactory;


    public $timestamps = false;

    protected $table = 'favorites';

    protected $fillable = [
        'user_id',
        'product_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function products(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
