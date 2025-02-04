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
        Schema::create('candidats', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée
            $table->unsignedBigInteger('secteur_id')->nullable(); // Clé étrangère vers secteurs
            $table->unsignedBigInteger('langue_id')->nullable(); // Clé étrangère vers langues
            $table->string('first_name'); // Prénom
            $table->string('last_name'); // Nom de famille
            $table->string('email')->unique(); // Email unique
            $table->string('tel')->nullable(); // Numéro de téléphone
            $table->string('password'); // Mot de passe haché
            $table->date('date_of_birth')->nullable(); // Date de naissance
            $table->string('adresse')->nullable(); // Adresse
            $table->enum('gender', ['male', 'female'])->nullable(); // Genre
            $table->enum('is_active', ['active', 'inactive'])->default('active'); // Actif/Inactif
            $table->string('cv_file_path')->nullable(); // Chemin du fichier CV
            $table->enum('priority', ['yes', 'no'])->default('yes'); // Priorité : 1=Faible
            $table->string('avatar_path')->nullable(); // Photo de profil
            $table->string('personal_picture_path')->nullable(); // Photo personnelle
            $table->timestamps(); // Colonnes created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidats');
    }
};
