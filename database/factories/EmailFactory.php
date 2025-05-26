<?php

namespace Database\Factories;

use App\Models\Classification;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Email>
 */
class EmailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'from' => $this->faker->email,
            'to' => $this->faker->email,
            'body' => $this->faker->paragraphs(3, true),
            'category_id' => $this->faker->word,
            'has_attachment' => $this->faker->boolean,
            'attachment_type' => $this->faker->randomElement(['PDF', 'DOCX', 'TXT']),
            'attachment_text' => $this->faker->text(100),
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'subject' => $this->faker->sentence,
            'sujet' => $this->faker->sentence,
            'commentaire' => $this->faker->optional()->text,
            'traitement' => $this->faker->randomElement(['En attente', 'Traité', 'En cours']),
            'dateTraitement' => $this->faker->optional()->date(),
            'status' => $this->faker->randomElement(['libre', 'bloque', 'affecte']),
        ];
    }
}
