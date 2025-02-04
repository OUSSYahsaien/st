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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_offer')->unsigned();
            $table->bigInteger('id_candidat')->unsigned();
            $table->enum('status', ['Evaluacion', 'En proceso', 'Entrevista', 'Confirmada', 'Descartado'])->default('Evaluacion');
            $table->text('motivation_letter')->nullable();
            $table->string('cv_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
