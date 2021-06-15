<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FlowItemUpdateRequest extends FormRequest
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
            'flow_id'=>"required",
            'list_operator_id'=>"required",
            'has_action' =>"required",
            'description'=>"required",
            'trigger'=>"required",
            'trigger_rule'=>"required",
            'trigger_value'=>"required",
            'type_reference_list'=>"required",
            'type_list'=>"required",
            'order'=>"required",
            'list_tag'=>"required",
            'type_question'=>"required"
        ];
    }
}
