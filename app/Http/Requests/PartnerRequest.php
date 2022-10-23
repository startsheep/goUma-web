<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartnerRequest extends FormRequest
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
        if ($this->method() == 'PUT') {
            $logo = 'image|mimes:jpeg,png,jpg,gif|max:4096';
        } else {
            $logo = 'required|image|mimes:jpeg,png,jpg,gif|max:4096';
        }
        return [
            'nama' => 'required',
            'alamat' => 'required',
            'kota' => 'required',
            'provinsi' => 'required',
            'kodepos' => 'required',
            'email' => 'required|email|unique:partners,email',
            'telp' => 'required|unique:partners,telp',
            'logo' => $logo
        ];
    }
}
