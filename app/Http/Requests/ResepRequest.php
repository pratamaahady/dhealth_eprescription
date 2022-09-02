<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResepRequest extends FormRequest
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
            'nama_pasien' => 'required|string',
            'obatalkes' => 'nullable|array',
            'obatalkes.*' => 'required|array',
            'obatalkes.*.id' => 'required|integer|exists:App\Models\ObatAlkes,obatalkes_id',
            'obatalkes.*.signa_id' => 'required|integer|exists:App\Models\Signa,signa_id',
            'obatalkes.*.quantity' => 'required|min:1',
            'obatalkes_racikan' => 'nullable|array',
            'obatalkes_racikan.*' => 'required|array',
            'obatalkes_racikan.*.id' => 'nullable|integer|exists:App\Models\ObatAlkesRacikan,id',
            'obatalkes_racikan.*.nama' => 'required|string',
            'obatalkes_racikan.*.signa_id' => 'required|integer|exists:App\Models\Signa,signa_id',
            'obatalkes_racikan.*.quantity' => 'required|min:1',
            'obatalkes_racikan.*.obatalkes' => 'nullable|array',
            'obatalkes_racikan.*.obatalkes.*' => 'required|array',
            'obatalkes_racikan.*.obatalkes.*.id' => 'required|integer|exists:App\Models\ObatAlkes,obatalkes_id',
            'obatalkes_racikan.*.obatalkes.*.quantity' => 'required|min:1',
        ];
    }
}
