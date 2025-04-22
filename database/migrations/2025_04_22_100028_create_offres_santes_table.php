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
        Schema::create('offres_sante', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('mutuelle_id');
            $table->string('titre');
            $table->text('description')->nullable();
            $table->string('type_soin');
            $table->decimal('remboursement_max', 10, 2);
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->timestamps();

            $table->foreign('mutuelle_id')->references('id')->on('mutuelles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offres_santes');
    }
};
