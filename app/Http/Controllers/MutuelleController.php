<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Mutuelles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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

    public function searchClientByNumeroSocial($uuid)
    {
        $client = Clients::where('id', $uuid)->first();

        if (! $client || $client->mutuelle_id !== Auth::user()->id) {
            abort(403, 'Accès non autorisé');
        }

        return view('mutuelles.searchResult', compact('client'));
    }

    public function loginView()
    {
        return view('mutuelles.login');
    }

    public function homeView()
    {
        return view('mutuelles.home');
    }

    public function logout()
    {
        Auth::guard('mutuelles')->logout();

        return redirect('/');
    }

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
            'password' => 'required|string|min:8',
        ]);

        $mutuelle->update([
            'nom' => $request->nom,
            'email_contact' => $request->email_contact,
            'password' => Hash::make($request->password),
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
