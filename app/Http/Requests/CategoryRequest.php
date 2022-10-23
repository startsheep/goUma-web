<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        $parentId = $this->get('parent_id');
        $id = $this->get('id');
        if ($this->method() == 'PUT') {
            if ($parentId > 0) {
                $nama = 'required|unique:categories,nama,' . $id . ',id,parent_id,' . $parentId;
            } else {
                $nama = 'required|unique:categories,nama,' . $id;
            }
        } else {
            $nama = 'required|unique:categories,nama,NULL,id,parent_id,' . $parentId;
        }

        return [
            'nama' => $nama,
            'satuan' => 'required',
        ];
    }
}
