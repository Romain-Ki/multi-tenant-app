<?php

namespace App\Http\Controllers;

use App\Models\Mutuelles;

class AffichageDataController extends Controller
{
    public function mutelles()
    {
        $mutuelles = Mutuelles::all();

        return view('affichageData.mutelles', compact('mutuelles'));
    }
}
