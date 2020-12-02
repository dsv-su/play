<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PresentationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'presentation_id' => 'required',
            'title' => 'required',
            'thumb' => 'required',
            'start' => 'required',
            'end' => 'required',
            'presenter' => 'required',
            'tags' => 'required',
            'course_id' => 'required',
        ];
    }
}
