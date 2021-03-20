<?php

namespace Database\Factories;

use App\Models\Password;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Crypt;

class PasswordFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Password::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'password' => Crypt::encryptString($this->faker->password),
            'login' => 'test',
            'web_address' => $this->faker->title,
            'description' => $this->faker->title,
        ];
    }
}
