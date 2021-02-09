<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\CourseVideo;
use Validator;

class StoreQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Gate::allows('question_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $same_for_all =  $this->request->get('same_for_all');
        $validatefields = [];
        $validatefields['quiz_id'] = ['required'];
        $languages = config('panel.available_languages');
        if(count($languages) > 0){
            foreach($languages as $key => $value){
                $validatefields[$key.'_title'] = ['required'];
                if($same_for_all=='1'){
                    $validatefields['en_attachment'] = ['required'];
                } else {
                    $validatefields[$key.'_attachment'] = ['required'];
                }
            }
        }
        
        return $validatefields;
    }
}
