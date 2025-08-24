<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:users,name',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => [
                'required',
                'confirmed',
                'string',
                'min:8',
                'max:255',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
            'password_confirmation' => 'required|string|min:8',
        ];
    }

    /**
     * Get custom error messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama pengguna diperlukan.',
            'name.unique' => 'Nama pengguna ini telah digunakan.',
            'email.required' => 'Emel diperlukan.',
            'email.email' => 'Sila masukkan alamat emel yang sah.',
            'email.unique' => 'Emel ini telah digunakan.',
            'password.required' => 'Kata laluan diperlukan.',
            'password.min' => 'Kata laluan mestilah sekurang-kurangnya 8 aksara.',
            'password.mixedCase' => 'Kata laluan mestilah mengandungi huruf besar dan kecil.',
            'password.letters' => 'Kata laluan mestilah mengandungi huruf.',
            'password.numbers' => 'Kata laluan mestilah mengandungi nombor.',
            'password.symbols' => 'Kata laluan mestilah mengandungi simbol khas.',
            'password.uncompromised' => 'Kata laluan ini telah muncul dalam kebocoran data. Sila pilih kata laluan lain.',
            'password.confirmed' => 'Pengesahan kata laluan tidak sepadan.',
            'password_confirmation.required' => 'Pengesahan kata laluan diperlukan.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'nama pengguna',
            'email' => 'emel',
            'password' => 'kata laluan',
            'password_confirmation' => 'pengesahan kata laluan',
        ];
    }
}
