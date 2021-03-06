<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('user_create');
    }

    public function rules()
    {
        return [
            'name'     => [
                'required',
            ],
            'isd_code'     => [
                'required',
            ],
            'email'    => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
            ],
            'phone'    => [
                'required',
                'digits_between:8,12',
                'unique:users',
            ],
            'password' => [
                'required',
            ],
            'role'    => [
                'required',
            ],
        ];
    }
}
