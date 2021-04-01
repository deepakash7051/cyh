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
        $rule = [];
        if( $this->has('first_propsal')  ){
            $rule = [
                'first_price'=>'required|regex:/^\d+(\.\d{1,2})?$/',
    
                'first_desc'=>['required'],
    
                //'attachment' => 'required',
                //'attachment.*'=>'image:jpeg,png,jpg,gif,svg|max:2048'
            ];
        }

        if( $this->has('second_proposal')  ){
            $rule = [
                'second_price'=>'required|regex:/^\d+(\.\d{1,2})?$/',
                'second_desc'=>['required'],
            ];
        }

        if( $this->has('third_propsal')  ){
            $rule = [
                 'third_price'=>'required|regex:/^\d+(\.\d{1,2})?$/',
                 'third_desc'=>['required']
            ];
        }

        return $rule;
    }
}
