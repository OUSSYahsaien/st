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
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_candidat'); // Relation avec le talent
            $table->string('company_name'); // Nom de l'entreprise
            $table->string('post'); // Poste occupé
            $table->string('location')->nullable(); // Lieu de travail
            $table->date('begin_date'); // Date de début
            $table->date('end_date')->nullable(); // Date de fin (nullable si toujours en cours)
            $table->enum('work_type', ['Tiempo completo', 'Media jornada', 'Remoto', 'Hibrido', 'Jornada intensiva'])->default('Tiempo completo'); // Type de travail
            $table->text('description')->nullable(); // Description de l'expérience
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
