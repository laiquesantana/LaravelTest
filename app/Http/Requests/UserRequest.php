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
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'tipo' => ['required'],
            'password' => ['required', 'string', 'min:8'],
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
                'name.required' => 'O nome é obrigatório !',
                'email.required'  => 'O email é obrigatório !',
                'email.unique'  => 'O email já está cadastrado!',
                'email.email'  => 'O formato do email está incorreto!',
                'email.max'  => 'O email deve possui 255 caracteres !',
                'password.required'  => 'A senha é obrigatoria!',
                'password.string'  => 'formato da senha inválida!',
                'password.min'  => 'A senha deve possui no mínimo 8 caracteres!',
                'tipo.required'  => 'O tipo é obrigatório !',
            ];
        }
}
