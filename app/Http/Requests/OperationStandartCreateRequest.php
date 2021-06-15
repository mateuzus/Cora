<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OperationStandartCreateRequest extends FormRequest
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
            'network_id'=>'required',
            'code'=>'required',
            'sector'=>'required',
            'name'=>'required',
            'target'=>'required',
            'references'=>'required',
            'material'=>'required',
            'schedule'=>'required',
        ];
    }
}
