<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\CourseVideo;
use Validator;

class UpdateQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Gate::allows('question_edit');
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
        $sametextans_for_all =  $this->request->has('sametextans_for_all') ? $this->request->get('sametextans_for_all') : '0';
        $samemcqans_for_all =  $this->request->has('samemcqans_for_all') ? $this->request->get('samemcqans_for_all') : '0';
        $sametextoption_for_all =  $this->request->has('sametextoption_for_all') ? $this->request->get('sametextoption_for_all') : '0';
        $sameimgoption_for_all =  $this->request->has('sameimgoption_for_all') ? $this->request->get('sameimgoption_for_all') : '0';

        $visible =  $this->request->get('visible');
        $type = $this->request->get('type');
        $option_label =  $this->request->get('option_label');

        $validatefields = [];
        $validatefields['quiz_id'] = ['required'];
        $validatefields['type'] = ['required'];
        //$validatefields['visible'] = ['required'];
        $languages = config('panel.available_languages');
        if(count($languages) > 0){
            foreach($languages as $key => $value){

                if($type=='0'){
                    if($sametextans_for_all=='1'){
                        $validatefields['en_correct_answer'] = ['required'];
                    } else {
                        $validatefields[$key.'_correct_answer'] = ['required'];
                    }
                } else {
                    $validatefields['option_label'] = ['required'];

                    if($samemcqans_for_all=='1'){
                        $validatefields['en_mcqcorrect_answer'] = ['required'];
                    } else {
                        $validatefields[$key.'_mcqcorrect_answer'] = ['required'];
                    }

                    if($option_label=='text'){
                        if($sametextoption_for_all=='1'){
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
                    } else {

                        if($sameimgoption_for_all=='1'){
                            $validatefields['en_option_attachment_a'] = !empty($this->request->get('en_old_option_attachment_a')) ? ['mimes:jpeg,jpg,png,gif'] : ['required', 'mimes:jpeg,jpg,png,gif'];

                            $validatefields['en_option_attachment_b'] = !empty($this->request->get('en_old_option_attachment_b')) ? ['mimes:jpeg,jpg,png,gif'] : ['required', 'mimes:jpeg,jpg,png,gif'];

                            $validatefields['en_option_attachment_c'] = !empty($this->request->get('en_old_option_attachment_c')) ? ['mimes:jpeg,jpg,png,gif'] : ['required', 'mimes:jpeg,jpg,png,gif'];

                            $validatefields['en_option_attachment_d'] = !empty($this->request->get('en_old_option_attachment_d')) ? ['mimes:jpeg,jpg,png,gif'] : ['required', 'mimes:jpeg,jpg,png,gif'];
                        } else {
                            $validatefields[$key.'_option_attachment_a'] = !empty($this->request->get($key.'_old_option_attachment_a')) ? ['mimes:jpeg,jpg,png,gif'] : ['required', 'mimes:jpeg,jpg,png,gif'];
                            $validatefields[$key.'_option_attachment_b'] = !empty($this->request->get($key.'_old_option_attachment_b')) ? ['mimes:jpeg,jpg,png,gif'] : ['required', 'mimes:jpeg,jpg,png,gif'];
                            $validatefields[$key.'_option_attachment_c'] = !empty($this->request->get($key.'_old_option_attachment_c')) ? ['mimes:jpeg,jpg,png,gif'] : ['required', 'mimes:jpeg,jpg,png,gif'];
                            $validatefields[$key.'_option_attachment_d'] = !empty($this->request->get($key.'_old_option_attachment_d')) ? ['mimes:jpeg,jpg,png,gif'] : ['required', 'mimes:jpeg,jpg,png,gif'];
                        }

                    }
                }

                /*if($type=='0' && $visible=='text'){
                    $validatefields[$key.'_title'] = ['required'];
                } else if($type=='0' && $visible=='image'){
                    if($same_for_all=='1'){
                        $validatefields['en_attachment'] = !empty($this->request->get('en_oldattachment')) ? ['mimes:jpeg,jpg,png,gif'] : ['required', 'mimes:jpeg,jpg,png,gif'];
                    } else {
                        $validatefields[$key.'_attachment'] = !empty($this->request->get($key.'_oldattachment')) ? ['mimes:jpeg,jpg,png,gif'] : ['required', 'mimes:jpeg,jpg,png,gif'];
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
                        $validatefields['en_attachment'] = !empty($this->request->get('en_oldattachment')) ? ['mimes:jpeg,jpg,png,gif'] : ['required', 'mimes:jpeg,jpg,png,gif'];
                    } else {
                        $validatefields[$key.'_attachment'] = !empty($this->request->get($key.'_oldattachment')) ? ['mimes:jpeg,jpg,png,gif'] : ['required', 'mimes:jpeg,jpg,png,gif'];
                    }
                } else {}
                
                if($sameans_for_all=='1'){
                    $validatefields['en_correct_answer'] = ['required'];
                } else {
                    $validatefields[$key.'_correct_answer'] = ['required'];
                }*/
            }
        }
        
        return $validatefields;
    }
}
