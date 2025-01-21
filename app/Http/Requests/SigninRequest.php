<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SigninRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'filled'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'filled', 'min:5'],
            // 'rule' => ['required', 'accepted']
        ];
    }
}
