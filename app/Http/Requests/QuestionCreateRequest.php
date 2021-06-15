<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionCreateRequest extends FormRequest
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
            'list_id'=>'required',
            'description'=>'required',
            'mandatory'=>'required',
            'question_status'=>'required',
            'question_type'=>'required',
            'weight_question'=>'required',
            'has_action'=>'required|boolean',
            'link_video'=>'required',
            'amount'=>'required',
        ];
    }
}
