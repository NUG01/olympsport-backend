<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => ['required', Rule::unique('users')->ignore($this->user)],
            'email' => ['required', Rule::unique('users')->ignore($this->user)],
            'password' => 'required',
            'city' => 'required',
            'address' => 'sometimes',
            'phone_number' => 'required',
            'avatar' => 'required',
        ];
    }
}
