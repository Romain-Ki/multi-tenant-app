<?php

namespace Database\Seeders;

use App\Models\Mutuelles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MutuelleSeeder extends Seeder
{
    public function run(): void
    {
        Mutuelles::create([
            'id' => Str::uuid(),
            'nom' => 'Mutuelle Santé Plus',
            'email_contact' => 'contact@santeplus.fr',
        ]);

        Mutuelles::create([
            'id' => Str::uuid(),
            'nom' => 'Mutuelle Bien-Être',
            'email_contact' => 'info@bienetre.fr',
        ]);
    }
}
