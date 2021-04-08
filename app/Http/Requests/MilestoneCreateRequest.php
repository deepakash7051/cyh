<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class MilestoneCreateRequest extends FormRequest
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
            'title'=>['required'],
            'price'=>'required|regex:/^\d+(\.\d{1,2})?$/',
            'type'=>['required'],
            'order'=>'required|integer|unique:milestones'
        ];
    }
}
