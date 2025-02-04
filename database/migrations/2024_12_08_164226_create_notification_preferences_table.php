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
        Schema::create('notification_preferences', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('candidat_id');
            $table->enum('job_opportunities', ['yes', 'no'])->default('no'); // Oportunidades Laborales
            $table->enum('newsletter', ['yes', 'no'])->default('no');        // Boletín Informativo
            $table->enum('privacy_consent', ['yes', 'no'])->default('no');   // Privacidad de la Información
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_preferences');
    }
};
