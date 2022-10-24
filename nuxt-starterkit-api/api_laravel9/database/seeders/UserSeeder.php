<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultUser = [
            'name' => 'User',
            'email' => 'user@user.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('12345678'),
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        User::insert($defaultUser);
        User::factory()->count(30)->create();
    }
}
