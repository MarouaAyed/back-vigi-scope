<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $appointments = Appointment::query()
                ->with(['employee', 'client'])
                ->when($request->employee_id, function ($query, $employeeId) {
                    $query->where('employee_id', $employeeId);
                })
                ->when($request->client_id, function ($query, $clientId) {
                    $query->where('client_id', $clientId);
                })
                ->get();

            return response()->json($appointments);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'date' => 'required|date',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'nullable|date_format:H:i|after:start_time',
                'employee_id' => 'required|exists:users,id',
                'client_id' => 'required|exists:users,id',
                'status' => 'required|in:pending,confirmed,cancelled',
                'notes' => 'nullable|string',
            ]);

            $appointment = Appointment::create($validated);

            return response()->json(['message' => 'Appointment created successfully', 'appointment' => $appointment], 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        try {
            return response()->json($appointment->load(['employee', 'client']));
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        try {
            $validated = $request->validate([
                'title' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'date' => 'nullable|date',
                'start_time' => 'nullable|date_format:H:i',
                'end_time' => 'nullable|date_format:H:i|after:start_time',
                'status' => 'nullable|in:pending,confirmed,cancelled',
                'notes' => 'nullable|string',
            ]);

            $appointment->update($validated);

            return response()->json(['message' => 'Appointment updated successfully', 'appointment' => $appointment]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        try {
            $appointment->delete();

            return response()->json(['message' => 'Appointment deleted successfully']);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
