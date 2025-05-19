<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'traitement_acceptes_refuses',
            'mise_a_jour_donnees_rh',
            'gestion_effectifs',
            'inscriptions_portails_spst',
            'export_data',
            'import_data',
            'delete_records',
            'access_dashboard',
            'manage_permissions',
            'create_users',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $roles = [
            'administrateur' => $permissions, // Administrateur a toutes les permissions
            'gestionnaire' => [
                'traitement_acceptes_refuses',
                'mise_a_jour_donnees_rh',
                'export_data',
                'access_dashboard',
            ],
            'superviseur' => [
                'traitement_acceptes_refuses',
                'gestion_effectifs',
                'inscriptions_portails_spst',
                'export_data',
                'import_data',
                'access_dashboard',
                'manage_permissions',
            ],
            'employe_societe_client' => [
                'traitement_acceptes_refuses',
                'mise_a_jour_donnees_rh',
                'export_data',
                'access_dashboard',
            ],
            'manager_societe_client' => [
                'traitement_acceptes_refuses',
                'mise_a_jour_donnees_rh',
                'export_data',
                'access_dashboard',
                'manage_permissions',
            ],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::create(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }
    }
}
