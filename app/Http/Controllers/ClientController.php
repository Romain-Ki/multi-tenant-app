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
            'password' => 'required|string|min:6|confirmed',
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
            'password' => Hash::make($request->password),
            'telephone' => $validated['telephone'],
            'adresse' => $validated['adresse'],
            'rib_encrypted' => Crypt::encryptString($validated['rib_encrypted']),
            'historique_medical_encrypted' => Crypt::encryptString($validated['historique_medical_encrypted'] ?? ''),
        ]);

        $client->save();

        return redirect()->back()->with('status', 'Compte client créé avec succès !');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email_contact', 'password');

        $client = Clients::where('email', $credentials['email_contact'])->first();
        if (! $client || ! Hash::check($credentials['password'], $client->password)|| $client ->email != $credentials['email_contact']) {
            return redirect()->route('client.login')->with('error', 'La connection a échoué: mauvais mail ou mot de passe.');
        }

        // Optionnel : Générer un token ici si tu utilises Sanctum ou JWT

        if ($client) {
            Auth::guard('clients')->login($client); // ✅ Authentification réelle

            return redirect()->route('client.home')->with('status', 'Réussi connard');
        } else {
            return redirect()->route('client.login')->with('error', 'La connection a échoué: nothing.');
        }

    }

    public function homeView()
    {
        $client = Auth::guard('clients')->user();
    
        // Décryptage des données sensibles
        $client->numero_securite_sociale = Crypt::decryptString($client->numero_securite_sociale_encrypted);
        $client->rib = Crypt::decryptString($client->rib_encrypted);
        $client->historique_medical = Crypt::decryptString($client->historique_medical_encrypted ?? '');
    
        return view('clients.dashboard', compact('client'));
    }
    

}

