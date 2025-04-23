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
        Schema::create('clients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('mutuelle_id');
            $table->string('nom');
            $table->string('prenom');
            $table->binary('numero_securite_sociale_encrypted');
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->text('adresse')->nullable();
            $table->binary('rib_encrypted')->nullable();
            $table->binary('historique_medical_encrypted')->nullable();
            $table->timestamps();

            $table->foreign('mutuelle_id')->references('id')->on('mutuelles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
