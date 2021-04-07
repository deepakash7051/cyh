<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankDetailRequest extends FormRequest
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
        if($this->has('proposal_initial_amount')){
            $rule = ['proposal_initial_amount' => 'regex:/^\d+(\.\d{1,2})?$/'];
        }else{
            $rule = [
                'bank_name' => ['required'],
                'beneficiary_name' => ['required'],
                'account_number' => ['required'],
                'ifsc_code' => ['required'],
            ];
        }
        return $rule;
    }
}
