<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ObatAlkesRequest extends FormRequest
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
        $id = $this->id ?? "";
        return [
            "obatalkes_kode" => "required|string|unique:App\Models\ObatAlkes,obatalkes_kode,$id,id",
            "obatalkes_nama" => "required|string",
            "additional_data" => "nullable|string"
        ];
    }
}
