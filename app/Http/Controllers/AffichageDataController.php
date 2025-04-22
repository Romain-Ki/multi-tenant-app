<?php

namespace App\Http\Controllers;

use App\Models\Mutuelle;

class AffichageDataController extends Controller
{
    public function mutelles()
    {
        $mutuelles = Mutuelle::all();

        return view('affichageData.mutelles', compact('mutuelles'));
    }
}
