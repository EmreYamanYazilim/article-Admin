<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            "email" => ["email", "exists:users", "required"],// botlarla email var mı yok mu deneme yapabiliyorlar bunun için mesajla  exists bölümünde böyle kullanıcı emaili yoktur tarzında bırakmamak için messages function ile başka  bir yazı vericem
            "password" => ["required"]
        ];
    }

    public function messages()
    {
        return [
            "email.exists" => "Bilgilerinizi kontrol edin !",
            "password.required" => "Şifre zorunludur",
        ];
    }
}
