<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

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
            'password' => Hash::make('12345678'),
        ]);

        $user->assignRole($role);

        // Mechanic user
        $mechanicRole = Role::firstOrCreate(['name' => 'mechanic']);
        $mechanic = User::firstOrCreate([
            'email' => 'mechanic@localhost',
        ], [
            'name' => 'mechanic',
            'password' => Hash::make('12345678'),
        ]);
        $mechanic->assignRole($mechanicRole);
    }
}
