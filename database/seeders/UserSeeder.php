<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'administrateur']);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456789'),
            'created_at' => Carbon::create(2025, 3, 10, 10, 0, 0),
        ]);

        $admin->assignRole($adminRole);

        $users = [
            [
                'name' => 'Jean Dubois',
                'email' => 'jean.dubois@expleo.com',
                'password' => bcrypt('password123'),
                'actif' => true,
                'departement' => 1,
                'role_name' => 'gestionnaire',
            ],
            [
                'name' => 'Sophie Martin',
                'email' => 'sophie.martin@expleo.com',
                'password' => bcrypt('password123'),
                'actif' => true,
                'departement' => 2,
                'role_name' => 'superviseur',
            ],
            [
                'name' => 'Paul Richard',
                'email' => 'paul.richard@expleo.com',
                'password' => bcrypt('password123'),
                'actif' => false,
                'departement' => 3,
                'role_name' => 'administrateur',
            ],
        ];

        foreach ($users as $userData) {
            $roleName = $userData['role_name'];
            unset($userData['role_name']); // Supprimez la clé 'role_name' de l'array

            $user = User::create($userData);

            $role = Role::firstOrCreate(['name' => $roleName]);

            $user->assignRole($role);
        }
    }
}
