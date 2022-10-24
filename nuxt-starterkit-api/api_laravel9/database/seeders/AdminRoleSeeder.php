<?php

namespace Database\Seeders;

use App\Models\AdminRole;
use Illuminate\Database\Seeder;

class AdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRoles = [
            [
                'id' => 1,
                'name' => 'SUPER_ADMIN',
                'label' => 'スーパー管理者',
            ],
            [
                'id' => 2,
                'name' => 'ADMIN',
                'label' => '管理者',
            ],
        ];

        AdminRole::insert($adminRoles);
    }
}
