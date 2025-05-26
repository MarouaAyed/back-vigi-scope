<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->enum('type', ['entreprise_privee', 'organisation_publique']);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('company');
            $table->string('vat_number')->nullable(); // matricule fiscale
            $table->text('notes')->nullable();
            $table->integer('number_of_employees');
            $table->date('collaboration_start_date');
            $table->string('medical_center')->nullable();

            $table->string('address_name')->nullable();
            $table->string('address_street')->nullable();
            $table->string('address_postal_code')->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_country')->default('France');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
