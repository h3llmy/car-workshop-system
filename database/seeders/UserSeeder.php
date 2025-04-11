<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::firstOrCreate(['name' => 'customer']);
        User::firstOrCreate([
            'name' => 'admin',
            'email' => 'admin@localhost',
            'password' => 'admin',
            'role_id' => $role->id,
        ]);
    }
}
