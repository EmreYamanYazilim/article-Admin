<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->name;
        return [
            "name"            => $name,
            "slug"            => Str::slug($name),
            "status"          => fake()->boolean,
            "feature_status"  => fake()->boolean,
            "description"     => fake()->paragraph,
//            "parent_id"     => random_int(1,22),   alt kategori oluşturmak için  ilk başta  yorum satırına alıyorum
            "order"           => random_int(1,1111),
            "seo_keywords"    => Str::slug(fake()->address, ", "), // adres verip arasını virgülle ayırıp boşluk bıraktırdım keyword girmişiz gibi olsun
            "seo_description" => fake()->text,
            "user_id"         => random_int(1,10),

        ];
    }
}
