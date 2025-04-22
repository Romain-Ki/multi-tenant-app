<?php

namespace App\Http\Controllers;

use App\Models\Mutuelles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
            return response()->json($validator->errors(), 422);
        }

        $mutuelle = Mutuelles::create([
            'id' => $request->nom.'0001',
            'nom' => $request->nom,
            'email_contact' => $request->email_contact,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Compte mutuelle créé avec succès', 'mutuelle' => $mutuelle], 201);
    }

    // ✅ Connexion
    public function login(Request $request)
    {
        $credentials = $request->only('email_contact', 'password');

        $mutuelle = Mutuelles::where('email_contact', $credentials['email_contact'])->first();

        if (! $mutuelle || ! Hash::check($credentials['password'], $mutuelle->password)) {
            return response()->json(['error' => 'Email ou mot de passe invalide'], 401);
        }

        // Optionnel : Générer un token ici si tu utilises Sanctum ou JWT

        return response()->json(['message' => 'Connexion réussie', 'mutuelle' => $mutuelle]);
    }
}
