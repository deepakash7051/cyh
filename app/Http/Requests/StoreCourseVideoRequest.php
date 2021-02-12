<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\CourseVideo;
use Validator;

class StoreCourseVideoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Gate::allows('video_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $same_for_all =  $this->request->has('same_for_all') ? $this->request->get('same_for_all') : '0';
        $validatefields = [];
        $validatefields['course_id'] = ['required'];
        $languages = config('panel.available_languages');
        if(count($languages) > 0){
            foreach($languages as $key => $value){
                $validatefields[$key.'_title'] = ['required'];
                if($same_for_all=='1'){
                    //$validatefields['en_attachment'] = ['required'];
                    $validatefields['en_attachment'] =['mimes:mp4,3gp,avi,flv,m3u8,ts,wmv,mov,ogg','required'];
                } else {
                    //$validatefields[$key.'_attachment'] = ['required'];
                    $validatefields[$key.'_attachment'] =['mimes:mp4,3gp,avi,flv,m3u8,ts,wmv,mov,ogg','required'];
                }
            }
        }
        
        return $validatefields;
    }
}
