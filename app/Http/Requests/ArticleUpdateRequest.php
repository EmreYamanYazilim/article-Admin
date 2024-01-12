<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleUpdateRequest extends FormRequest
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
            "title" => ["max:255","required"],
            "slug" => ["max:255","unique:articles,slug,".$this->id], // kendisi ile alakalı aynı veri gelirse işlemi ypaacak ama kendisi dışında aynı veri gelirse onu geçirmeyecek
            "body" => ["required"],
            "category_id" => ["required"],
            "image" => ["image", "mimetypes:image/jpeg,image/jpg,image/png", "max:2048"]



        ];
    }
}
