<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamMembersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('full_name');
            $table->string('poste');
            $table->string('location');
            $table->string('email')->unique();
            $table->string('tel_1');
            $table->string('tel_2')->nullable();
            $table->string('personel_pic')->nullable();
            $table->string('avatar_pic')->nullable();
            $table->enum('role', ['responsable', 'employe'])->default('employe');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_members');
    }
}
