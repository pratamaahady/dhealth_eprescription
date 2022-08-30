<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $id = $this->user ? $this->user->id : '';
        return [
            'name' => 'string|required',
            'username' => "string|required|unique:App\Models\User,username,$id,id",
            'password'  => [
                "string",
                "confirmed",
                "nullable",
                Rule::requiredIf(function() use($id){
                    return empty($id); // required if create request
                })
            ],
            'group_id' => 'required|integer|exists:App\Models\Group,id',
        ];
    }
}
