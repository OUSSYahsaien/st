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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_company'); // Relation avec le talent
            $table->string('title');
            $table->integer('nbr_candidat_max');
            $table->integer('nbr_candidat_confermed')->default(0);
            $table->string('place');
            $table->enum('work_type', ['Tiempo completo', 'Media jornada', 'Remoto', 'Hibrido', 'Jornada intensiva'])
                ->default('Tiempo completo');
            $table->decimal('starting_salary', 10, 2);
            $table->decimal('final_salary', 10, 2);
            $table->string('category');
            $table->integer('experience_years');
            $table->enum('priority', ['yes', 'no'])->default('no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
