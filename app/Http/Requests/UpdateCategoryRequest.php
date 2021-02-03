<?php

namespace App\Http\Requests;

use App\Category;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('category_edit');
    }

    public function rules()
    {
        $validatefields = [];
        $languages = config('panel.available_languages');
        if(count($languages) > 0){
            foreach($languages as $key => $value){
                $validatefields[$key.'_name'] = ['required'];
            }
        }
        return $validatefields;
    }
}
