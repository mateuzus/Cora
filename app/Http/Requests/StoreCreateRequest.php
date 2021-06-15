<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCreateRequest extends FormRequest
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
            'description' =>"required",
            'network_id' =>"required",
            'name' =>"required",
            'code' =>"required"
        ];
    }

    public function messages(){
        return [

            'required.network_id'=>"O ID da rede é obrigatório",


        ];
    }
}
