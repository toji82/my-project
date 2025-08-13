<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition(): array
    {
        $gender = $this->faker->randomElement(['男性','女性','その他']);

        // 既存のカテゴリからランダムに1件取得（必ずIDを入れる）
        $categoryId = Category::inRandomOrder()->value('id') ?? 1;

        return [
            'last_name'   => $this->faker->lastName(),
            'first_name'  => $this->faker->firstName(),
            'gender'      => $gender,
            'email'       => $this->faker->unique()->safeEmail(),
            'tel'         => $this->faker->numerify('0##########'),
            // address()は改行を含むことがあるので、気になるなら streetAddress() にすると安全
            'address'     => $this->faker->streetAddress(), 
            'building'    => $this->faker->optional()->secondaryAddress(),
            'category_id' => $categoryId,
            'content'     => mb_substr($this->faker->realText(80), 0, 120),
        ];
    }
}
