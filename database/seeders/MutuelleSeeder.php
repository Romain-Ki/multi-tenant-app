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
            'password' => 'test1',
            'email_contact' => 'contact@santeplus.fr',
        ]);

        Mutuelles::create([
            'id' => Str::uuid(),
            'nom' => 'Mutuelle Bien-Être',
            'password' => 'test2',
            'email_contact' => 'info@bienetre.fr',
        ]);
    }
}
