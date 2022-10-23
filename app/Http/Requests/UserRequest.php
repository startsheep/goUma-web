<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        $id = $this->get('id');
        if ($this->method() == 'PUT') {
            $password = 'nullable|min:8';
            $email = 'required|unique:users,email,' . $id;
            $telp = 'required|unique:users,telp,' . $id;
        } else {
            $password = 'required|min:8';
            $email = 'required|unique:users,email,NULL';
            $telp = 'required|unique:users,telp,NULL';
        }

        return [
            'name' => 'required',
            'last_name' => 'required',
            'email' => $email,
            'level' => 'required',
            'password' => $password,
            'telp' => $telp
        ];
    }
}
