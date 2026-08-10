<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class SignupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El campo nombre es obligatorio.',
            'email.required' => 'El campo email es obligatorio.',
            'password.required' => 'El campo password es obligatorio.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos :min caracteres.',
            'password.numbers' => 'La contraseña debe contener al menos un número.',
            'password.uncompromised' => 'La contraseña ha sido comprometida en una filtración de datos. Por favor, elige otra contraseña.',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 
                Password::min(8)
                    //->letters()
                    //->mixedCase()
                    //->numbers()
                    //->symbols()
                    ->uncompromised()
            ],
        ];
    }
}
