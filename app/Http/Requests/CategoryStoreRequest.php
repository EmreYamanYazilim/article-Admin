<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
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
            "name" => ["required", "max:255"],
            "slug" => ["max:255"],
            "description" => ["max:255"],
            "seo_keyword" => ["max:255"],
            "seo_description" => ["max:255"],
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "Kategori Adı Alanı Doldurması Zornuludur",
            "name.max" => "Kategori Alani Maksimum  80 olmalidir",
            "slug.max" => "Kategori Slug alani Maksimum 80 olmalidir",
            "description.max" => "Kategori Açıklama Alani Maksimum  255 olmalidir",
            "seo_keyword.max" => "Kategori Seo Keywords Alani Maksimum  255 olmalidir",
            "seo_description.max" => "Kategori seo description Alani Maksimum  255 olmalidir"
        ];
    }
}
