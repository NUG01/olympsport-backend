<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Config;

class ProductResource extends JsonResource
{
    private static mixed $token = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'category' => $this->categories->makeHidden(['id', 'parent_id']),
            'state' => Config::get('product-assets.states')[$this->state],
            'description' => $this->description,
            'color' => $this->when($this->color !== null, function () {
                return Config::get('product-assets.colors')[$this->color];
            }),
            'size' => $this->when($this->size !== null, function () {
                $explode = explode('|', $this->size);
                if (str_contains($explode[1], 'x')) return $explode[1];
                if ($explode[0] === 'foot') {
                    return Config::get('product-assets.foot_sizes')[$explode[1]];
                } else {
                    return Config::get('product-assets.sizes')[$explode[1]];
                }
            }),
            'brand' => $this->brand,
            'owner' => $this->user,
            'photos' => $this->photos,
            'boosted' => $this->boosted,
            'favorite' => $this->when($this->favorite, function () {
                if ($this->favorite->count() !== 0) {
                    foreach ($this->favorite as $favorite) {
                        if ($favorite->user_id !== self::$token) return false;
                    }
                    return true;
                }

                return false;
            }),
        ];
    }

    public static function customCollection($resource, $data): AnonymousResourceCollection
    {
        self::$token = $data;
        return parent::collection($resource);
    }

    public static function customMake($resource, $data): ProductResource
    {
        self::$token = $data;
        return parent::make($resource);
    }
}
