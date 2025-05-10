<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'administrateur']);
        Role::create(['name' => 'gestionnaire']);
        Role::create(['name' => 'employe_societe_client']);
        Role::create(['name' => 'manager_societe_client']);
    }
}
