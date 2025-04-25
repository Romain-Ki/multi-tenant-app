<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord | {{ auth()->user()->nom }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-gray-100 text-gray-900">

    <header class="bg-blue-600 text-white py-4 px-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold">Tableau de bord de {{ auth()->user()->nom }}</h1>
        <nav>
            <a href="{{ route('client.logout') }}" class="text-white hover:underline">Déconnexion</a>
        </nav>
    </header>

    <main class="p-6">
    <h2 class="text-xl font-semibold mb-4">Bienvenue, {{ $client->prenom }} {{ $client->nom }} !</h2>

    <div class="bg-white p-6 rounded shadow-md w-full max-w-xl">
    <h3 class="text-lg font-bold mb-4">Vos informations personnelles</h3>

    <ul class="space-y-2">
        <li><strong>Email :</strong> {{ $client->email }}</li>
        <li><strong>Téléphone :</strong> {{ $client->telephone }}</li>
        <li><strong>Adresse :</strong> {{ $client->adresse }}</li>
        <li><strong>Numéro de Sécurité Sociale :</strong> {{ $client->numero_securite_sociale }}</li>
        <li><strong>RIB :</strong> {{ $client->rib }}</li>
        <li><strong>Historique Médical :</strong> {{ $client->historique_medical ?: 'Non renseigné' }}</li>
        <li><strong>Mutuelle :</strong> {{ $client->mutuelle->nom ?? 'Non associée' }}</li>
    </ul>
</div>

        
        
    </main>

</body>
</html>
