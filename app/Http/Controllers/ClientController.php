<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Mutuelles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends Controller
{
    public function showLoginForm()
    {
        $mutuelles = Mutuelles::all();

        return view('clients.login', compact('mutuelles'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'mutuelle_id' => 'required|uuid',
            'numero_securite_sociale_encrypted' => 'required|string|max:15',
            'email' => 'required|email|unique:clients,email',
            'password' => 'required|string|min:6|confirmed',
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
            'rib_encrypted' => 'required|string|max:34',
            'historique_medical_encrypted' => 'nullable|string',
        ]);

        try {
            $mutuelle = Mutuelles::findOrFail($validated['mutuelle_id']);

            $client = Clients::create([
                'id' => Str::uuid(),
                'nom' => $validated['nom'],
                'prenom' => $validated['prenom'],
                'mutuelle_id' => $validated['mutuelle_id'],
                'numero_securite_sociale_encrypted' => Crypt::encryptString($validated['numero_securite_sociale_encrypted']),
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'telephone' => $validated['telephone'],
                'adresse' => $validated['adresse'],
                'rib_encrypted' => Crypt::encryptString($validated['rib_encrypted']),
                'historique_medical_encrypted' => Crypt::encryptString($validated['historique_medical_encrypted'] ?? ''),
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => "Compte client {$client->nom} créé avec succès pour la mutuelle {$mutuelle->nom} !",
                    'client_id' => $client->id,
                    'mutuelle_id' => $client->mutuelle_id,
                    'mutuelle_nom' => $mutuelle->nom,
                ], Response::HTTP_CREATED);
            }

            return redirect()->back()->with('status', 'Compte client créé avec succès !');

        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'enregistrement du client : ' . $e->getMessage());

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Erreur lors de la création du compte client.',
                    'error' => $e->getMessage(),
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            return redirect()->back()->withErrors('Erreur lors de la création du compte client. Veuillez réessayer.');
        }
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email_contact' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $client = Clients::where('email', $validated['email_contact'])->first();

        if (! $client || ! Hash::check($validated['password'], $client->password)) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'La connexion a échoué : mauvais email ou mot de passe.',
                ], Response::HTTP_UNAUTHORIZED);
            }
            return redirect()->route('client.login')->with('error', 'La connexion a échoué : mauvais email ou mot de passe.');
        }

        Auth::guard('clients')->login($client);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Connexion réussie.',
                'client_id' => $client->id,
                'mutuelle_id' => $client->mutuelle_id,
            ], Response::HTTP_OK);
        }

        return redirect()->route('client.home')->with('status', 'Connexion réussie.');
    }

    public function homeView(Request $request)
    {
        $client = Auth::guard('clients')->user();

        if (!$client) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Accès refusé.'], Response::HTTP_FORBIDDEN);
            }
            abort(Response::HTTP_FORBIDDEN, 'Accès refusé.');
        }

        $client->numero_securite_sociale = Crypt::decryptString($client->numero_securite_sociale_encrypted);
        $client->rib = Crypt::decryptString($client->rib_encrypted);
        $client->historique_medical = Crypt::decryptString($client->historique_medical_encrypted ?? '');

        if ($request->wantsJson()) {
            return response()->json([
                'client' => $client,
            ]);
        }

        return view('clients.dashboard', compact('client'));
    }

    public function editProfile(Request $request)
    {
        $client = Auth::guard('clients')->user();

        if (!$client) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Accès refusé.'], Response::HTTP_FORBIDDEN);
            }
            abort(Response::HTTP_FORBIDDEN, 'Accès refusé.');
        }

        $mutuelles = Mutuelles::all();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => "Page d'édition du profil",
                'client' => [
                    'id' => $client->id,
                    'nom' => $client->nom,
                    'prenom' => $client->prenom,
                    'email' => $client->email,
                    'mutuelle_id' => $client->mutuelle_id,
                ],
                'mutuelles' => $mutuelles,
            ]);
        }

        return view('clients.edit-profile', compact('client', 'mutuelles'));
    }

    public function updateProfile(Request $request)
    {
        $client = Auth::guard('clients')->user();

        if (!$client) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Accès refusé.'], Response::HTTP_FORBIDDEN);
            }
            abort(Response::HTTP_FORBIDDEN, 'Accès refusé.');
        }

        $validated = $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
            'mutuelle_id' => 'required|uuid',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $client->update([
            'prenom' => $validated['prenom'],
            'nom' => $validated['nom'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'],
            'adresse' => $validated['adresse'],
            'mutuelle_id' => $validated['mutuelle_id'],
            'password' => !empty($validated['password']) ? Hash::make($validated['password']) : $client->password,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Profil mis à jour avec succès.',
                'client' => $client,
            ]);
        }

        return redirect()->route('client.home')->with('status', 'Profil mis à jour avec succès !');
    }

    public function destroy(Request $request, $id)
    {
        $client = Clients::find($id);

        if (! $client) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Client introuvable.'], Response::HTTP_NOT_FOUND);
            }
            return redirect()->back()->withErrors('Client introuvable.');
        }

        $client->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Client supprimé avec succès.']);
        }

        return redirect()->route('client.home')->with('status', 'Client supprimé avec succès.');
    }
}
