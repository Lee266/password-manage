<?php

namespace Database\Seeders;

use App\Models\UserSample;
use Illuminate\Database\Seeder;

class UserSampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserSample::factory()->count(60)->create();
    }
}
