<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListingCreateRequest extends FormRequest
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
            'description'=>'required',
            'user_id'=>'required',
            'creation_date'=>'required|date',
            'type'=>'required',
            'status'=>'required',
            'list_tag'=>'required',
            'period_end'=>'required',
            'period_start'=>'required',
            
        ];
    }
}
