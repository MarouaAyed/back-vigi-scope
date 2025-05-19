<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{

    /**
     * Retrieve the list of managers.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_managers(): JsonResponse
    {
        try {
            $users = User::whereHas('roles', function ($query) {
                $query->where('name', 'gestionnaire');
            })->with('roles')->get();

            $allPermissions = Permission::pluck('name')->toArray();

            $formattedManagers = $users->map(function ($user) use ($allPermissions) {
                $role = $user->roles->first();
                $roleName = $role ? $role->name : null;

                $userPermissions = $user->getAllPermissions()->pluck('name')->toArray();

                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'actif' => (bool) $user->actif,
                    'departement' => $user->departement,
                    'role' => $roleName,
                    'permissions' => $userPermissions,

                    'canCreateUsers' => in_array('create_users', $userPermissions),
                    'canExportData' => in_array('export_data', $userPermissions),
                    'canImportData' => in_array('import_data', $userPermissions),
                    'canDeleteRecords' => in_array('delete_records', $userPermissions),
                    'canAccessDashboard' => in_array('access_dashboard', $userPermissions),
                    'canManagePermissions' => in_array('manage_permissions', $userPermissions),
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Liste des managers récupérée avec succès.',
                'data' => $formattedManagers,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la récupération des managers.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Show the form for creating a new resource.
     */

    public function index(): JsonResponse
    {
        try {
            $users = User::whereDoesntHave('roles', function ($query) {
                $query->where('name', 'administrateur');
            })->with('roles')->get();

            // Récupération de toutes les permissions pour correspondance plus bas
            $allPermissions = Permission::pluck('name')->toArray();

            $formattedUsers = $users->map(function ($user) use ($allPermissions) {
                $role = $user->roles->first(); // Récupère le 1er rôle (supposé unique)
                $roleName = $role ? $role->name : null;

                // Permissions de l'utilisateur via Spatie
                $userPermissions = $user->getAllPermissions()->pluck('name')->toArray();

                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'actif' => (bool) $user->actif,
                    'departement' => $user->departement,
                    'role' => $roleName,
                    'permissions' => $userPermissions,

                    // Mappage des booléens en fonction des permissions
                    'canCreateUsers' => in_array('create_users', $userPermissions),
                    'canExportData' => in_array('export_data', $userPermissions),
                    'canImportData' => in_array('import_data', $userPermissions),
                    'canDeleteRecords' => in_array('delete_records', $userPermissions),
                    'canAccessDashboard' => in_array('access_dashboard', $userPermissions),
                    'canManagePermissions' => in_array('manage_permissions', $userPermissions),
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Liste des utilisateurs récupérée avec succès (sans administrateurs).',
                'data' => $formattedUsers,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la récupération des utilisateurs.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
