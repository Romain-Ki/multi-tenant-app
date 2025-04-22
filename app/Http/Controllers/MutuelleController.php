<?php

namespace App\Http\Controllers;

use App\Models\Mutuelles;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MutuelleController extends Controller
{
    /**
     * Affiche le formulaire de création d'une nouvelle mutuelle.
     */
    public function create()
    {
        return view('mutuelles.create');
    }

    /**
     * Enregistre une nouvelle mutuelle en base.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email_contact' => 'nullable|email|max:255',
        ]);

        Mutuelles::create([
            'id' => Str::uuid(),
            'nom' => $request->nom,
            'email_contact' => $request->email_contact,
        ]);

        return redirect()->route('mutuelles')->with('success', 'Mutuelle créée avec succès.');
    }

    /**
     * Affiche une mutuelle spécifique.
     */
    public function show(Mutuelles $mutuelle)
    {
        return view('mutuelles.show', compact('mutuelle'));
    }

    /**
     * Affiche le formulaire d'édition d'une mutuelle.
     */
    public function edit(Mutuelles $mutuelle)
    {
        return view('mutuelles.edit', compact('mutuelle'));
    }

    /**
     * Met à jour une mutuelle existante.
     */
    public function update(Request $request, Mutuelles $mutuelle)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email_contact' => 'nullable|email|max:255',
        ]);

        $mutuelle->update([
            'nom' => $request->nom,
            'email_contact' => $request->email_contact,
        ]);

        return redirect()->route('mutuelles')->with('success', 'Mutuelle mise à jour avec succès.');
    }

    /**
     * Supprime une mutuelle.
     */
    public function destroy(Mutuelles $mutuelle)
    {
        $mutuelle->delete();
        return redirect()->route('mutuelles')->with('success', 'Mutuelle supprimée avec succès.');
    }
}
