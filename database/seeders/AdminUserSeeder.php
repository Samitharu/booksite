<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@booksite.com'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('password123'),
            ]
        );

        // Ensure role exists
        $adminRole = Role::firstOrCreate(
            ['name' => 'Admin'],
            ['guard_name' => 'web']
        );

        // Attach role using pivot table (force insert)
        DB::table('model_has_roles')->updateOrInsert([
            'role_id'    => $adminRole->id,
            'model_type' => User::class,
            'model_id'   => $admin->id,
        ]);
    }
}
