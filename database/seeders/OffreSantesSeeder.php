<?php

namespace Database\Seeders;

use App\Models\Mutuelles;
use App\Models\OffreSantes;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OffreSantesSeeder extends Seeder
{
    public function run(): void
    {
        $mutuelle = Mutuelles::first();

        OffreSantes::create([
            'id' => Str::uuid(),
            'mutuelle_id' => $mutuelle->id,
            'titre' => 'Remboursement optique',
            'description' => 'Jusqu\'à 200€ remboursés',
            'type_soin' => 'optique',
            'remboursement_max' => 200,
            'date_debut' => now()->subMonth(),
            'date_fin' => now()->addYear(),
        ]);
    }
}
