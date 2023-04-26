<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'children' => $this->when($this->children !== null, function () use ($request) {
                if ($request->routeIs('categories.index')) {
                    return $this->whenLoaded('children');
                } elseif ($request->routeIs('categories.show')) {
                    return $this->children;
                } else {
                    return $this->whenLoaded('children');
                }
            }),
        ];
    }
}
