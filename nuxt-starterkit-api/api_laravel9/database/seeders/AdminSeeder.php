<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\AdminRole;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $superAdmin = [
            'id' => 1,
            'company_id' => null,
            'admin_role_id' => AdminRole::SUPER_ADMIN_ID,
            'name' => 'Super Admin',
            'email' => 'superadmin@admin.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('12345678'),
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        $admin = [
            'id' => 2,
            'company_id' => null,
            'admin_role_id' => AdminRole::ADMIN_ID,
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('12345678'),
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        // Create default admins
        Admin::insert([$superAdmin, $admin]);

        // Create random Admin
        Admin::factory()->count(10)->admin()->create();

        // Create random Super Admin
        Admin::factory()->count(10)->superAdmin()->create();

    }
}
