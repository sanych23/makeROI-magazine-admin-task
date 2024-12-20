<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => 'required|max:100',
            'email' => 'required|unique:users',
            'password' => 'required|string|min:10|max:100',
            'phone' => 'required|string|min:11|max:11',
            'birthday' => 'required|date',
        ];
    }
}
