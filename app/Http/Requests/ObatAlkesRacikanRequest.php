<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ObatAlkesRacikanRequest extends FormRequest
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
            "obatalkes_racikan_nama" => 'required|string',
            'obatalkes' => 'required|array',
            'obatalkes.*' => 'required|array',
            'obatalkes.*.id' => 'required|integer|exists:App\Models\ObatAlkes,obatalkes_id',
            'obatalkes.*.quantity' => 'required|min:1',
        ];
    }
}
