<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string',
//            'photos' => 'required',
            'category_id' => 'required',
            'state' => 'required|integer',
            'description' => 'required',
            'color' => 'sometimes',
            'brand' => 'required',
            'size' => 'sometimes',
            'boosted' => 'sometimes',
        ];
    }
}
