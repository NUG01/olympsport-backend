<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'category' => $this->category,
            'state' => $this->state,
            'description' => $this->desription,
            'color' => $this->color,
            'size' => $this->size,
            'owner' => $this->user,
            'photos' => $this->photos,
        ];
    }
}
