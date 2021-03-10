<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Validator;

class UpdateModuleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Gate::allows('module_edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $same_video_for_all =  $this->request->has('same_video_for_all') ? $this->request->get('same_video_for_all') : '0';
        $same_slide_for_all =  $this->request->has('same_slide_for_all') ? $this->request->get('same_slide_for_all') : '0';
        $link_attachment =  $this->request->get('link_attachment');

        $validatefields = [];
        $validatefields['course_id'] = ['required'];
        $languages = config('panel.available_languages');
        if(count($languages) > 0){
            foreach($languages as $key => $value){
                $validatefields[$key.'_title'] = ['required'];

                if($link_attachment=='video'){
                    
                    if($same_video_for_all=='1'){
                        $validates = !empty($this->request->get('en_old_video')) || !empty($this->request->get('en_video_link')) ? ['mimes:mp4,3gp,avi,flv,m3u8,ts,wmv,mov,ogg'] : ['mimes:mp4,3gp,avi,flv,m3u8,ts,wmv,mov,ogg','required']  ;

                        $validatefields['en_video'] = $validates;
                    } else {
                        $validates = !empty($this->request->get($key.'_old_video')) || !empty($this->request->get($key.'_video_link')) ? ['mimes:mp4,3gp,avi,flv,m3u8,ts,wmv,mov,ogg'] : ['mimes:mp4,3gp,avi,flv,m3u8,ts,wmv,mov,ogg','required']  ;
                        $validatefields[$key.'_video'] = $validates;
                    }

                } else {
                    if($same_slide_for_all=='1'){
                        $validates = !empty($this->request->get('en_old_slide')) ? ['mimes:pptx'] : ['mimes:ppt,pptx','required']  ;
                        $validatefields['en_slide'] = $validates;
                    } else {
                        $validates = !empty($this->request->get($key.'_old_slide')) ? ['mimes:pptx'] : ['mimes:ppt,pptx','required']  ;
                        $validatefields[$key.'_slide'] = $validates;
                    }
                }
            }
        }
        
        return $validatefields;
    }
}
