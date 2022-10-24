<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = $this->faker;
        return [
            'name' => $faker->company(),
            'address' => $faker->address(),
            'city' => $faker->city(),
            'phone' => $faker->phoneNumber(),
            'website' => $faker->url(),
        ];
    }
}
