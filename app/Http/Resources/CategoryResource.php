<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'children' => $this->when($request->routeIs('categories.*'), function () use ($request) {
                if ($request->routeIs('categories.index')) {
                    return $this->whenLoaded('children');
                } elseif ($request->routeIs('categories.show')) {
                    return $this->children;
                }
            }),
        ];
    }
}
