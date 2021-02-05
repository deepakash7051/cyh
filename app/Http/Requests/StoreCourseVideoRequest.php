<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\CourseVideo;

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
        return [
            'attachment'         => [
                'required',
            ],
            'course_id'         => [
                'required',
            ],
        ];
    }
}
