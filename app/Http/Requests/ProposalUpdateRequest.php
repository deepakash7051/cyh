<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProposalUpdateRequest extends FormRequest
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
        // if( $this->has('first_propsal')  ){
        //     $rule = [
        //         'price'=>'required|regex:/^\d+(\.\d{1,2})?$/',
        //         'desc'=>['required'],
        //         'attachment.*'=>'mimes:jpeg,png,jpg,gif,svg,pdf',

        //     ];
        // }

        // if( $this->has('second_propsal')  ){
        //     $rule = [
        //         'price'=>'required|regex:/^\d+(\.\d{1,2})?$/',
        //         'desc'=>['required'],
        //         'attachment.*'=>'mimes:jpeg,png,jpg,gif,svg,pdf'
        //     ];
        // }

        // if( $this->has('third_propsal')  ){
        //     $rule = [
        //          'price'=>'required|regex:/^\d+(\.\d{1,2})?$/',
        //          'desc'=>['required'],
        //          'attachment.*'=>'mimes:jpeg,png,jpg,gif,svg,pdf'
        //     ];
        // }
        $rule = [
            'price'=>'required|regex:/^\d+(\.\d{1,2})?$/',
            'desc'=>['required'],
            'attachment.*'=>'mimes:jpeg,png,jpg,gif,svg,pdf',

        ];
        return $rule;
    }
}
