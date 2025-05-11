<?php

namespace Database\Seeders;

use App\Models\Appointment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Appointment::insert([
            [
                'title' => 'Réunion d\'équipe',
                'description' => 'Discussion sur les objectifs du trimestre',
                'date' => '2025-05-06', 
                'start_time' => '10:00:00', 
                'end_time' => '11:30:00', 
                'status' => 'approved',
            ],
            [
                'title' => 'Entretien annuel',
                'description' => 'Bilan et objectifs',
                'date' => '2025-05-08', 
                'start_time' => '11:00:00', 
                'end_time' => '12:00:00',
                'status' => 'pending',
            ],
            [
                'title' => 'Réunion fournisseur',
                'description' => 'Négociation contrat annuel',
                'date' => '2025-05-09', 
                'start_time' => '14:00:00', 
                'end_time' => '15:00:00',
                'status' => 'cancelled',
            ],
        ]);
    }
}
