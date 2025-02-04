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
        Schema::create('offer_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_offer');
            $table->enum('status', ['Publicada', 'Revision', 'Cerrada'])
                ->default('Revision');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_statuses');
    }
};
