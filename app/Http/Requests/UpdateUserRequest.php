<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required',
            'phone' => 'phone|unique:users,phone,'.$this->route('usuarios'),
            'email' => 'required|email|unique:users,email,'.$this->route('usuarios'),
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Nombre es obligatorio',
            'email.required' => 'Correo obligatorio',
            'email.unique' => 'El correo ya fue registrado',
            'phone.unique' => 'El telefono ya fue registrado',
        ];
    }
}
