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
        Schema::create('demandes_remboursement', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('client_id');
            $table->uuid('offre_id')->nullable();
            $table->enum('statut', ['en_attente', 'en_cours', 'validee', 'refusee']);
            $table->decimal('montant', 10, 2);
            $table->date('date_demande')->default(null);
            $table->string('type_soin');
            $table->text('justificatif_path')->nullable();
            $table->binary('justificatif_encrypted')->nullable();
            $table->text('commentaire')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('offre_id')->references('id')->on('offres_sante')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandes_remboursements');
    }
};
