<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'categories' => $this->when($this->id !== null, function () use ($request) {
                if ($request->routeIs('admin.brands.index')) {
                    return $this->categories->count();
                } elseif ($request->routeIs('admin.brands.show')) {
                    return $this->categories;
                } else {
                    return $this->categories;
                }
            }),
            // 'products' => $this->when($this->id !== null, function () use ($request) {
            //     if ($request->routeIs('admin.brands.index')) {
            //         return $this->products->count();
            //     } elseif ($request->routeIs('admin.brands.show')) {
            //         return $this->products;
            //     } else {
            //         return $this->products;
            //     }
            // }),
        ];
    }
}
