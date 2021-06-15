<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NetworkUpdateRequest extends FormRequest
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
            'name'=>"required",
            'description'=>"required",
            'status'=>"required"
        ];
    }
    public function messsage(){
        return [
            'name.required'=>"O campo nome é obrigatório",
            'name.description'=>"O campo descrição é obrigatório",
            'status.required'=>"O campo status é obrigatório"
        ];
    }
}
