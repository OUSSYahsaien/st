<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE applications MODIFY COLUMN status ENUM('Evaluacion', 'En proceso', 'Entrevista', 'Confirmada', 'Descartado', 'Seleccionado') DEFAULT 'Evaluacion'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE applications MODIFY COLUMN status ENUM('Evaluacion', 'En proceso', 'Entrevista', 'Confirmada', 'Descartado') DEFAULT 'Evaluacion'");
    }
};
