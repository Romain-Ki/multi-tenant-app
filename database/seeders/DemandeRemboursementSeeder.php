<?php

namespace Database\Seeders;

use App\Models\Clients;
use App\Models\DemandeRemboursements;
use App\Models\OffreSantes;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class DemandeRemboursementSeeder extends Seeder
{
    public function run(): void
    {
        $client = Clients::first();
        $offre = OffreSantes::first();

        DemandeRemboursements::create([
            'id' => Str::uuid(),
            'client_id' => $client->id,
            'offre_id' => $offre->id,
            'statut' => 'en_attente',
            'montant' => 150,
            'date_demande' => now(),
            'type_soin' => 'optique',
            'justificatif_path' => null,
            'justificatif_encrypted' => Crypt::encrypt('facture opticien 2025.pdf'),
            'commentaire' => 'Lunettes de vue achetées le 10 avril.',
        ]);
    }
}
