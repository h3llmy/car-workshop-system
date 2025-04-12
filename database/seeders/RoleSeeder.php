<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            [
                'name' => 'super admin',
                'guard_name' => 'web'            
            ],
            [
                'name' => 'car owner',
                'guard_name' => 'web'            
            ],
                        [
                'name' => 'mechanic',
                'guard_name' => 'web'           
            ]
        ]);
    }
}
