<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|regex:/^[a-zA-Z0-9\'\s]+$/',
            'last_name' => 'required|regex:/^[a-zA-Z0-9\'\s]+$/',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ];
    }
}
