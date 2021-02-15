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

        $same_for_all =  $this->request->has('same_for_all') ? $this->request->get('same_for_all') : '0';
        $sameans_for_all =  $this->request->has('sameans_for_all') ? $this->request->get('sameans_for_all') : '0';
        $sameoption_for_all =  $this->request->has('sameoption_for_all') ? $this->request->get('sameoption_for_all') : '0';
        $visible =  $this->request->get('visible');
        $type = $this->request->get('type');
        $validatefields = [];
        $validatefields['quiz_id'] = ['required'];
        $validatefields['type'] = ['required'];
        $validatefields['visible'] = ['required'];
        $languages = config('panel.available_languages');
        if(count($languages) > 0){
            foreach($languages as $key => $value){
                if($type=='0' && $visible=='text'){
                    $validatefields[$key.'_title'] = ['required'];
                } else if($type=='0' && $visible=='image'){
                    if($same_for_all=='1'){
                        $validatefields['en_attachment'] = ['required', 'mimes:jpeg,jpg,png,gif'];
                    } else {
                        $validatefields[$key.'_attachment'] = ['required', 'mimes:jpeg,jpg,png,gif'];
                    }
                } else if($type=='1' && $visible=='text'){
                    $validatefields[$key.'_title'] = ['required'];
                    if($sameoption_for_all=='1'){
                        $validatefields['en_option_a'] = ['required'];
                        $validatefields['en_option_b'] = ['required'];
                        $validatefields['en_option_c'] = ['required'];
                        $validatefields['en_option_d'] = ['required'];
                    } else {
                        $validatefields[$key.'_option_a'] = ['required'];
                        $validatefields[$key.'_option_b'] = ['required'];
                        $validatefields[$key.'_option_c'] = ['required'];
                        $validatefields[$key.'_option_d'] = ['required'];
                    }
                } else if($type=='1' && $visible=='image'){
                    if($same_for_all=='1'){
                        $validatefields['en_attachment'] = ['required', 'mimes:jpeg,jpg,png,gif'];
                    } else {
                        $validatefields[$key.'_attachment'] = ['required', 'mimes:jpeg,jpg,png,gif'];
                    }
                } else {}
                
                if($sameans_for_all=='1'){
                    $validatefields['en_correct_answer'] = ['required'];
                } else {
                    $validatefields[$key.'_correct_answer'] = ['required'];
                }
            }
        }
        
        return $validatefields;
    }
}


