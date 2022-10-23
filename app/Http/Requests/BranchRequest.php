<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
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
        $id = $this->get('id');
        if ($this->method() == 'PUT') {
            $email = 'required|unique:branches,email,' . $id;
            $telp = 'required|unique:branches,telp,' . $id;
            $foto = 'image|mimes:jpeg,png,jpg,gif|max:4096';
        } else {
            $email = 'required|unique:branches,email,NULL';
            $telp = 'required|unique:branches,telp,NULL';
            $foto = 'required|image|mimes:jpeg,png,jpg,gif|max:4096';
        }
        return [
            'nama' => 'required',
            'pimpinan' => 'required',
            'alamat' => 'required',
            'kota' => 'required',
            'provinsi' => 'required',
            'kodepos' => 'required',
            'email' => $email,
            'telp' => $telp,
            'foto' => $foto
        ];
    }
}
