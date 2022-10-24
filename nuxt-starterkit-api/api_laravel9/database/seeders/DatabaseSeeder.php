<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CompanySeeder::class,
            AdminRoleSeeder::class,
            AdminSeeder::class,

            UserSeeder::class,
            PostcodeSeeder::class,
            UserSampleSeeder::class,
        ]);
    }
}
