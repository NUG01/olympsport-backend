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
<<<<<<< HEAD
            'children' => $this->when($this->id !== null, function () use ($request) {
=======
            'parent' => Category::where(
                'id',
                $this->parent_id
            )->first(),
            'children' => $this->when($this->children !== null, function () use ($request) {
>>>>>>> 4d2dea9518cd89c2e4c1533653f80c8c4de71714
                if ($request->routeIs('categories.index')) {
                    return $this->whenLoaded('children');
                } elseif ($request->routeIs('categories.show')) {
                    return $this->children;
<<<<<<< HEAD
=======
                } elseif ($request->routeIs('admin.categories.index')) {
                    return $this->children->count();
>>>>>>> 4d2dea9518cd89c2e4c1533653f80c8c4de71714
                } elseif ($request->routeIs('admin.categories.show')) {
                    return $this->children;
                } else {
                    return null;
                }
            }),
        ];
    }
}
