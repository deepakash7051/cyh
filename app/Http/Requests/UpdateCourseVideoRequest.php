<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\CourseVideo;

class UpdateCourseVideoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Gate::allows('video_edit');
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
