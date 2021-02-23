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

    public function rules()
    {
        $user_id =  $this->request->get('user_id');
        
        return [
            'name'    => [
                'required',
            ],
            'isd_code'     => [
                'required',
            ],
            'email' => 'required|email|unique:users,email,'.$user_id,
            'phone' => 'required|digits_between:8,12|unique:users,phone,'.$user_id,
            'role'   => [
                'required',
            ],
        ];
    }
}
