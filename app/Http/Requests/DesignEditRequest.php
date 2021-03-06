<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DesignEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Gate::allows('user_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required'],
            'attachments.*' => 'image:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }
}
