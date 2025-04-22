<?php

namespace Database\Seeders;

use App\Models\DemandeRemboursements;
use App\Models\EchangeDossier;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class EchangeDossierSeeder extends Seeder
{
    public function run(): void
    {
        $demande = DemandeRemboursements::first();

        EchangeDossier::create([
            'id' => Str::uuid(),
            'demande_id' => $demande->id,
            'auteur' => 'gestionnaire',
            'message' => 'Merci de fournir une facture détaillée.',
            'piece_jointe_path' => null,
            'piece_jointe_encrypted' => Crypt::encrypt('aucun document'),
        ]);
    }
}
