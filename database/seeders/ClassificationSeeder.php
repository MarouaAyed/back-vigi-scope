<?php

namespace Database\Seeders;

use App\Models\Classification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classifications = [
            "Traitement des Acceptés/Refusés",
            "Mise à jour des données RH",
            "Inscriptions sur les portails des SPST",
            "Relances des sans réponse et annulations",
            "Sollicitation des SPST pour les créneaux / reprise",
            "Relances concernant les attestations manquantes",
            "Gestion des effectifs",
            "DUERP",
            "Inscription VigiScope",
            "NOUVEAU PORTAIL",
            "Masses salariales",
            "Déclarations d'effectifs faites",
            "Déclarations portails à faire",
            "Déclaration des effectifs papiers à faire",
            "Dates d'ouvertures campagne de déclarations",
            "Import",
            "Adhésions",
            "Mot de passe portail",
            "Facturation et Paiement",
            "Gestion d'un planning de créneaux",
            "Client",
            "Mail salarié",
            "Saisie des Attestations de Suivi ou d'Aptitude",
            "Envoi aux salariés des convocations reçues",
            "Traitement des VM Refusées",
            "Traitement des VM Acceptées DASSYSTEM",
            "EXPLEO FRANCE",
        ];

        foreach ($classifications as $classification) {
            Classification::create(['name' => $classification]);
        }
    }
}