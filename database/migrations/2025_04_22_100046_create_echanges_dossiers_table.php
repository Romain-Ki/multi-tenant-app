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
        Schema::create('echanges_dossier', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('demande_id');
            $table->string('auteur');
            $table->text('message')->nullable();
            $table->text('piece_jointe_path')->nullable();
            $table->binary('piece_jointe_encrypted')->nullable();
            $table->timestamp('date_echange')->useCurrent();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->foreign('demande_id')->references('id')->on('demandes_remboursements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('echanges_dossier');
    }
};
