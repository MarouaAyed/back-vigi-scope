<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $client = Client::create([
                'first_name' => $data['firstName'],
                'last_name' => $data['lastName'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'type' => $data['type'],
                'status' => $data['status'],
                'company' => $data['company'],
                'vat_number' => $data['vatNumber'] ?? null,
                'notes' => $data['notes'] ?? null,
                'number_of_employees' => $data['numberOfEmployees'],
                'collaboration_start_date' => $data['collaborationStartDate'],
                'medical_center' => $data['medicalCenter'] ?? null,

                'address_name' => $data['addressName'] ?? null,
                'address_street' => $data['addressStreet'] ?? null,
                'address_postal_code' => $data['addressPostalCode'] ?? null,
                'address_city' => $data['addressCity'] ?? null,
                'address_country' => $data['addressCountry'] ?? 'France',
            ]);

            // 2. Attach Managers (unchanged)
            if (!empty($data['managers'])) {
                foreach ($data['managers'] as $managerData) {
                    $client->managers()->create([
                        'first_name' => $managerData['firstName'],
                        'last_name' => $managerData['lastName'],
                        'email' => $managerData['email'],
                        'phone' => $managerData['phone'] ?? null,
                        'position' => $managerData['position'],
                        'is_primary' => $managerData['isPrimary'],
                    ]);
                }
            }

            // 3. Attach Employees (unchanged)
            if (!empty($data['employees'])) {
                foreach ($data['employees'] as $employeeData) {
                    $client->employees()->create([
                        'first_name' => $employeeData['firstName'],
                        'last_name' => $employeeData['lastName'],
                        'email' => $employeeData['email'],
                        'position' => $employeeData['position'],
                        'phone' => $employeeData['phone'] ?? null,
                    ]);
                }
            }


            DB::commit();

            return response()->json([
                'message' => 'Client créé avec succès!',
                'client' => $client->load(['managers', 'employees'])
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erreur lors de la création du client.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        //
    }
}
