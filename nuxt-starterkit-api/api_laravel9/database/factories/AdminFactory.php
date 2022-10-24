<?php

namespace Database\Factories;

use App\Models\AdminRole;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $companies = Company::all();
        $adminRoles = AdminRole::all();

        return [
            'company_id' => $companies->random()->id,
            'admin_role_id' => $adminRoles->random()->id,
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'), // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Admin state with regular Admin role
     *
     * @return static
     */
    public function admin()
    {
        return $this->state(function () {
            return [
                'admin_role_id' => AdminRole::ADMIN_ID,
            ];
        });
    }

    /**
     * Admin state with Super Admin role
     *
     * @return static
     */
    public function superAdmin()
    {
        return $this->state(function () {
            return [
                'admin_role_id' => AdminRole::SUPER_ADMIN_ID,
            ];
        });
    }
}
