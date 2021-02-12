<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Course;

class UpdateCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Gate::allows('course_edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $validatefields = [];
        $validatefields['category_id'] = ['required'];
        $validatefields['ref_code'] = ['required'];
        $validatefields['price'] = ['required'];
        $validatefields['duration'] = ['required'];
        $validatefields['image'] = ['mimes:jpeg,jpg,png,gif'];
        $languages = config('panel.available_languages');
        if(count($languages) > 0){
            foreach($languages as $key => $value){
                $validatefields[$key.'_title'] = ['required'];
            }
        }
        return $validatefields;
    }
}
