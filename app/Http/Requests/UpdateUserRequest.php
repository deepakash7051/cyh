<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('user_edit');
    }

    public function rules(User $user)
    {
        return [
            'name'    => [
                'required',
            ],
            'isd_code'     => [
                'required',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255', 
            ],
            'phone'    => [
                'required',
                'integer',
                'min:10',
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
