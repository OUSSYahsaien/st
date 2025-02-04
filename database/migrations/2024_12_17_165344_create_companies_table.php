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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('secteur_id')->nullable();;
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('tel', 20)->nullable();
            $table->text('adress')->nullable();
            $table->string('city')->nullable();
            $table->string('poste');
            $table->string('cif')->nullable();
            $table->string('avatar_pic')->nullable();
            $table->string('personel_pic')->nullable();
            $table->string('website')->nullable();
            $table->integer('staf_nbr')->default(0);
            $table->enum('is_active', ['yes', 'no'])->default('yes');   
            $table->enum('is_homology', ['yes', 'no'])->default('no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
