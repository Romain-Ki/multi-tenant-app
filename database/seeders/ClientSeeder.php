<?php

namespace Database\Seeders;

use App\Models\Clients;
use App\Models\Mutuelles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $mutuelle = Mutuelles::first();

        Clients::create([
            'id' => Str::uuid(),
            'mutuelle_id' => $mutuelle->id,
            'nom' => 'Dupont',
            'prenom' => 'Alice',
            'numero_securite_sociale_encrypted' => Crypt::encrypt('1234567890123'),
            'email' => 'alice.dupont@mail.fr',
            'telephone' => '0612345678',
            'adresse' => '12 rue de la Santé, Paris',
            'rib_encrypted' => Crypt::encrypt('FR7612345987650123456789014'),
            'historique_medical_encrypted' => Crypt::encrypt('Aucune allergie connue'),
        ]);
    }
}
