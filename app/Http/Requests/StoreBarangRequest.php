<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBarangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //

            'nama_barang' => 'required',
            'kode_barang' => 'required',
            'harga_barang' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'nama_barang.required' => ':attribute nama barang harus diisi',
            'kode_barang.required' => ':attribute kode barang harus diisi',
            'harga_barang.required' => ':attribute harga barang harus diisi',
        ];
    }

    public function filter(){
        return ['nama_barang' => 'trim|capitalize|escape'];
    }
}
