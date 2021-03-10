<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\CourseVideo;
use Validator;

class StoreModuleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Gate::allows('module_create');
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
                        $validatefields['en_video'] = empty($this->request->get('en_video_link')) ? ['mimes:mp4,3gp,avi,flv,m3u8,ts,wmv,mov,ogg','required'] : ['mimes:mp4,3gp,avi,flv,m3u8,ts,wmv,mov,ogg'];
                    } else {
                        $validatefields[$key.'_video'] = empty($this->request->get($key.'_video_link')) ? ['mimes:mp4,3gp,avi,flv,m3u8,ts,wmv,mov,ogg','required'] : ['mimes:mp4,3gp,avi,flv,m3u8,ts,wmv,mov,ogg'];
                    }

                } else {
                    if($same_slide_for_all=='1'){
                        $validatefields['en_slide'] =['mimes:pptx','required'];
                    } else {
                        $validatefields[$key.'_slide'] =['mimes:pptx','required'];
                    }
                }
            }
        }
        
        return $validatefields;
    }
}
