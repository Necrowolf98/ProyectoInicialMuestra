<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'direction' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$this->user->id,
            'phone' => 'required|string|max:255',
            'password' => 'nullable|string|min:6|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo nombres es requerido',
            'lastname.required' => 'El campo apellidos es requerido',
            'direction.required' => 'El campo direccion es requerido',
            'email.required' => 'El campo email es requerido',
            'email.unique' => 'Este email ya se encuentra registrado',
            'email.email' => 'Utilize esta jerarquía correo@correo.com',
            'phone.required' => 'El campo telefono es requerido',
            'phone.min' => 'El campo telefono debe tener un mínimo de 10 números',
            'password.min' => 'Tu clave debe tener almenos 6 caracteres',
            'password.confirmed' => 'Las clave no coinciden',
        ];
    }
}
