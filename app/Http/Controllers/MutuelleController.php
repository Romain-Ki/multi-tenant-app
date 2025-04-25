<?php

namespace App\Http\Controllers;

use App\Models\Mutuelles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

class MutuelleController extends Controller
{
    // ✅ Enregistrement
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'email_contact' => 'required|email|unique:mutuelles,email_contact',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->route('mutuelle.login')->with('error', 'La création du compte a échoué. Veuillez réessayer.');
        }
        if (Mutuelles::where('nom', '=', $request->nom)->first()) {
            return redirect()->route('mutuelle.login')->with('error', 'La création du compte a échoué. Veuillez réessayer.');
        }

        $mutuelle = Mutuelles::create([
            'id' => Str::uuid(),
            'nom' => $request->nom,
            'email_contact' => $request->email_contact,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('mutuelle.login')->with('status', 'Compte créé avec succès !');
    }

    // ✅ Connexion
    public function login(Request $request)
    {
        $credentials = $request->only('email_contact', 'password');

        $mutuelle = Mutuelles::where('email_contact', $credentials['email_contact'])->first();

        if (! $mutuelle || ! Hash::check($credentials['password'], $mutuelle->password)) {
            return redirect()->route('mutuelle.login')->with('error', 'La connection a échoué: mauvais mail ou mot de passe.');
        }

        // Optionnel : Générer un token ici si tu utilises Sanctum ou JWT

        if ($mutuelle) {
            Auth::guard('mutuelles')->login($mutuelle); // ✅ Authentification réelle

            return redirect()->route('mutuelle.home');
        } else {
            return redirect()->route('mutuelle.login')->with('error', 'La connection a échoué: mauvais mail ou mot de passe.');
        }

    }

    public function loginView()
    {
        return view('mutuelles.login');
    }

    public function homeView()
    {
        return view('mutuelles.home');
    }

    public function listeClients()
{
    $mutuelle = Auth::guard('mutuelles')->user();

    $clients = $mutuelle->clients;

    foreach ($clients as $client) {
        $client->numero_securite_sociale = Crypt::decryptString($client->numero_securite_sociale_encrypted);
        $client->rib = Crypt::decryptString($client->rib_encrypted);
        $client->historique_medical = Crypt::decryptString($client->historique_medical_encrypted ?? '') ?? 'Non renseigné';
    }

    return view('mutuelles.client', compact('clients'));
}
}
