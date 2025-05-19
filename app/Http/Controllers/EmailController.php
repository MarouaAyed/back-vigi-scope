<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Email;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $emails = Email::whereNull('classification_id')->where('status', 'libre')
                ->with(['client', 'employee'])
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Liste des emails récupérée avec succès.',
                'data' => $emails
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la récupération des emails.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function emails_classified(): JsonResponse
    {
        try {
            // list in mail 
            $emails = Email::where('classification_id', '!=', null)
                ->where('status', 'affecte')
                ->with(['client', 'employee'])
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Liste des emails récupérée avec succès.',
                'data' => $emails
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la récupération des emails.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function emails_affected(): JsonResponse
    {
        try {
            // list in mail 
            $emails = Email::where('classification_id', '!=', null)
                ->where('status', 'affecte')
                ->with(['client', 'employee'])
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Liste des emails récupérée avec succès.',
                'data' => $emails
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la récupération des emails.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function affect_email(Request $request)
    {
        try {
            $validated = $request->validate([
                'classification_id' => 'required',
                'email' => 'required',
            ]);

            $email = Email::findOrFail($validated['email']);


            $email->classification_id = $validated['classification_id'];
            $email->status = 'affecte';
            $email->save();

            if ($validated['classification_id'] == "21") { // Classification Client
                try {
                    $dateTraitement = $email->dateTraitement ?? now(); // Default to current date if null
                    Appointment::create([
                        'title' => $email->name,
                        'description' => $email->sujet,
                        'notes' => $email->commentaire,
                        'date' => $dateTraitement,
                        'start_time' => $dateTraitement,
                    ]);
                } catch (\Throwable $th) {
                    Log::error('Failed to create appointment: ' . $th->getMessage());

                    return response()->json([
                        'message' => 'Failed to create appointment',
                        'error' => $th->getMessage()
                    ], 500);
                }
            }

            return response()->json(['message' => 'Affect success'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
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
    public function show(Email $email)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Email $email)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Email $email)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Email $email)
    {
        //
    }
}
