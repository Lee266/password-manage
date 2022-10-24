<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Postcode;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserSampleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = $this->faker;
        $gender = $faker->randomElements(['male', 'female']);

        $postcodes = Postcode::select(['id', 'postcode', 'prefecture_kana'])
            ->groupBy('prefecture_kana')->get();
        $randomPostcode = $postcodes->random();

        $admins = Admin::get();
        $randomAdmin = $admins->random();

        return [
            'admin_id' => $randomAdmin->id,
            'postcode_id' => $randomPostcode->id,

            'first_name' => $faker->firstName($gender[0]),
            'last_name' => $faker->lastName($gender[0]),
            'company' => $faker->company(),
            'address' => $faker->address(),
            'city' => $faker->city(),
            'country' => $faker->country(),
            'gender' => $faker->randomElements(['F', 'M'])[0],
            'phone' => $faker->phoneNumber(),
            'email' => $faker->unique()->safeEmail(),
            'password' => Hash::make('12345678'), // password
            'web' => $faker->url(),
        ];
    }
}
