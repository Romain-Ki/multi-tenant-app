<?php

namespace App\Http\Controllers;

use App\Models\Mutuelles;

class AffichageDataController extends Controller
{
    public function mutelles()
    {
        $mutuelles = Mutuelles::select('id', 'nom')->get();

        if (request()->wantsJson()) {
            return response()->json([
                'mutuelles' => $mutuelles
            ]);
        }

        return view('affichageData.mutelles', compact('mutuelles'));
    }
}
