<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            $foto = 'image|mimes:jpeg,png,jpg,gif|max:4096';
        } else {
            $foto = 'required|image|mimes:jpeg,png,jpg,gif|max:4096';
        }
        return [
            'kode' => 'required',
            'partner_id' => 'required',
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
            'foto' => $foto,
        ];
    }
}
