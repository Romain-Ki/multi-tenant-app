<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Clients;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use App\Models\Mutuelles;

class ClientController extends Controller
{
    // Affiche le formulaire de connexion
    public function showLoginForm()
    {
        $mutuelles = Mutuelles::all();
        return view('clients.login', compact("mutuelles"));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'numero_securite_sociale_encrypted' => 'required|string|max:15',
            'email' => 'required|email|unique:clients,email',
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
            'rib_encrypted' => 'required|string|max:34',
            'historique_medical_encrypted' => 'nullable|string',
        ]);

        // Cryptage des données sensibles
        $client = new Clients([
            'id' => Str::uuid(),
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'mutuelle_id' => $request->mutuelle_id,
            'numero_securite_sociale_encrypted' => Crypt::encryptString($validated['numero_securite_sociale_encrypted']),
            'email' => $validated['email'],
            'telephone' => $validated['telephone'],
            'adresse' => $validated['adresse'],
            'rib_encrypted' => Crypt::encryptString($validated['rib_encrypted']),
            'historique_medical_encrypted' => Crypt::encryptString($validated['historique_medical_encrypted'] ?? ''),
        ]);

        $client->save();

        return redirect()->back()->with('status', 'Compte client créé avec succès !');
    }

}

