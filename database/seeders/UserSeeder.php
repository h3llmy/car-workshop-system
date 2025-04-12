<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::firstOrCreate(['name' => 'super admin']);
        $user = User::firstOrCreate([
            'name' => 'admin',
            'email' => 'admin@localhost',
            'password' => '12345678',
        ]);

        $user->assignRole($role);
    }
}
