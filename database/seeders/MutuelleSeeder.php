<?php

namespace Database\Seeders;

use App\Models\Mutuelles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MutuelleSeeder extends Seeder
{
    public function run(): void
    {
        Mutuelles::create([
            'id' => Str::uuid(),
            'nom' => 'Mutuelle Santé Plus',
            'password' => Hash::make('1234567890'),
            'email_contact' => 'test1@test1.com',
        ]);
    }
}
