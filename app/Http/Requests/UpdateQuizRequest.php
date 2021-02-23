<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Course;

class UpdateQuizRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Gate::allows('quiz_edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $unlimited_attempts =  $this->request->has('unlimited_attempts') ? $this->request->get('unlimited_attempts') : '0';
        $validatefields = [];
        $validatefields['course_id'] = ['required'];
        $validatefields['time_limit'] = ['required'];
        if($unlimited_attempts=='0'){
            $validatefields['attempts'] = ['integer'];
        }
        $languages = config('panel.available_languages');
        if(count($languages) > 0){
            foreach($languages as $key => $value){
                $validatefields[$key.'_title'] = ['required'];
            }
        }
        return $validatefields;
    }
}
