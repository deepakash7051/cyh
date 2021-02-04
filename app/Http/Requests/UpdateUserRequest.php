<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('user_edit');
    }

    public function rules()
    {
        return [
            'name'    => [
                'required',
            ],
            'isd_code'     => [
                'required',
            ],
            'email'   => [
                'required',
            ],
            'phone'    => [
                'required',
                'integer',
                'min:10',
                'unique:users',
            ],
            'roles.*' => [
                'integer',
            ],
            'roles'   => [
                'required',
                'array',
            ],
        ];
    }
}
