<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Mutuelles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class MutuelleController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255|unique:mutuelles,nom',
            'email_contact' => 'required|email|unique:mutuelles,email_contact',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            if ($request->wantsJson()) {
                return response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            return redirect()->route('mutuelle.login')->with('error', 'La création du compte a échoué.');
        }

        if (Mutuelles::where('nom', '=', $request->nom)->exists()) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Nom de mutuelle déjà utilisé.'], Response::HTTP_CONFLICT);
            }
            return redirect()->route('mutuelle.login')->with('error', 'La création du compte a échoué.');
        }

        $mutuelle = Mutuelles::create([
            'id' => Str::uuid(),
            'nom' => $request->nom,
            'email_contact' => $request->email_contact,
            'password' => Hash::make($request->password),
        ]);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Compte mutuelle créé avec succès.', 'mutuelle_id' => $mutuelle->id], Response::HTTP_CREATED);
        }

        return redirect()->route('mutuelle.login')->with('status', 'Compte créé avec succès !');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email_contact', 'password');

        $mutuelle = Mutuelles::where('email_contact', $credentials['email_contact'])->first();

        if (! $mutuelle || ! Hash::check($credentials['password'], $mutuelle->password)) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'La connexion a échoué : mauvais email ou mot de passe.'], Response::HTTP_UNAUTHORIZED);
            }
            return redirect()->route('mutuelle.login')->with('error', 'La connexion a échoué.');
        }

        Auth::guard('mutuelles')->login($mutuelle);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Connexion réussie.', 'mutuelle_id' => $mutuelle->id], Response::HTTP_OK);
        }

        return redirect()->route('mutuelle.home');
    }

    public function searchClientByNumeroSocial(Request $request, $numero)
    {
        $mutuelle = Auth::guard('mutuelles')->user();

        if (!$mutuelle) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Accès refusé.'], Response::HTTP_FORBIDDEN);
            }
            abort(Response::HTTP_FORBIDDEN, 'Accès refusé.');
        }

        $numero_encrypted = hash('sha256', $numero);
        $client = Clients::where('numero_securite_sociale_hashed', 'like', $numero_encrypted)->first();

        if (! $client) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Client inexistant.'], Response::HTTP_NOT_FOUND);
            }
            abort(Response::HTTP_NOT_FOUND, "Le client n'existe pas !");
        }

        if ($client->mutuelle_id !== $mutuelle->id) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Accès non autorisé.'], Response::HTTP_FORBIDDEN);
            }
            abort(Response::HTTP_FORBIDDEN, 'Accès non autorisé');
        }

        if ($request->wantsJson()) {
            return response()->json(['client' => $client], Response::HTTP_OK);
        }

        return view('mutuelles.searchResult', compact('client'));
    }

    public function loginView()
    {
        return view('mutuelles.login');
    }

    public function homeView(Request $request)
    {
        $mutuelle = Auth::guard('mutuelles')->user();

        if (!$mutuelle) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Accès refusé.'], Response::HTTP_FORBIDDEN);
            }
            abort(Response::HTTP_FORBIDDEN, 'Accès refusé.');
        }

        return view('mutuelles.home');
    }

    public function logout(Request $request)
    {
        Auth::guard('mutuelles')->logout();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Déconnexion réussie.'], Response::HTTP_OK);
        }

        return redirect('/');
    }

    public function show(Request $request, Mutuelles $mutuelle)
    {
        if ($request->wantsJson()) {
            return response()->json(['mutuelle' => $mutuelle], Response::HTTP_OK);
        }
        return view('mutuelles.show', compact('mutuelle'));
    }

    public function edit(Request $request, Mutuelles $mutuelle)
    {
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Accès de la page edit de la mutuelle',
                'mutuelle' => $mutuelle
            ], Response::HTTP_OK);
        }
        return view('mutuelles.edit', compact('mutuelle'));
    }

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

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Mutuelle mise à jour avec succès.', 'mutuelle' => $mutuelle], Response::HTTP_OK);
        }

        return redirect()->route('mutuelle.home')->with('status', 'Mutuelle mise à jour avec succès.');
    }

    public function destroy(Request $request, Mutuelles $mutuelle)
    {
        if (Auth::guard('mutuelles')->id() !== $mutuelle->id) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Action non autorisée.'], Response::HTTP_FORBIDDEN);
            }
            abort(Response::HTTP_FORBIDDEN, 'Action non autorisée.');
        }

        $mutuelle->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Mutuelle supprimée avec succès.', 'mutuelle_id' => $mutuelle->id], Response::HTTP_OK);
        }

        return redirect()->route('mutuelle.home')->with('status', 'Mutuelle supprimée avec succès.');
    }

    public function listeClients(Request $request)
    {
        $mutuelle = Auth::guard('mutuelles')->user();

        if (!$mutuelle) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Accès refusé.'], Response::HTTP_FORBIDDEN);
            }
            abort(Response::HTTP_FORBIDDEN, 'Accès refusé.');
        }

        $clients = $mutuelle->clients;

        foreach ($clients as $client) {
            $client->numero_securite_sociale = Crypt::decryptString($client->numero_securite_sociale_encrypted);
            $client->rib = Crypt::decryptString($client->rib_encrypted);
            $client->historique_medical = Crypt::decryptString($client->historique_medical_encrypted ?? '') ?? 'Non renseigné';
        }

        if ($request->wantsJson()) {
            return response()->json(['clients' => $clients], Response::HTTP_OK);
        }

        return view('mutuelles.client', compact('clients'));
    }
}
