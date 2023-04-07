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
            'children' => CategoryResource::collection($this->children),
        ];
    }

    public static function destroy($category)
    {
        $parent_ids = Category::whereNot('id', $category->id)->pluck('parent_id')->toArray();
        $parent_ids = collect($parent_ids)->flatten(1)->toArray();

        $result = array_diff($category->parent_id, $parent_ids);

        $result = array_values($result);

        DB::table('categories')->whereIn('id', $result)->delete();
        $category->delete();
    }
}
