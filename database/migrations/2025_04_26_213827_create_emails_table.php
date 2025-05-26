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
        Schema::create('emails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('client_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('employee_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('classification_id')->nullable()->constrained()->onDelete('cascade');

            $table->string('from');
            $table->string('to');
            $table->string('email');
            $table->string('subject');
            $table->text('body');
            $table->string('category_id');
            $table->boolean('has_attachment')->default(false);
            $table->string('attachment_type')->nullable();
            $table->text('attachment_text')->nullable();
            $table->enum('traitement', ['En attente', 'Traité', 'En cours'])->default('En attente');
            $table->enum('status', ['libre', 'bloque', 'affecte'])->default('libre');
            $table->date('dateTraitement')->nullable();

            $table->string('name')->nullable();
            $table->text('sujet')->nullable();
            $table->text('commentaire')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emails');
    }
};
