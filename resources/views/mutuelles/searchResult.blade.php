<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails Client | {{ $client->nom }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="bg-light">

    <header class="bg-primary text-white py-4 mb-4">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h4 m-0">Profil du Client</h1>
            <a href="{{ route('mutuelle.home') }}" class="btn btn-outline-light btn-sm">Retour au tableau de bord</a>
        </div>
    </header>

    <main class="container mb-5">
        <div class="card shadow-lg rounded-4">
            <div class="card-body">
                <h2 class="card-title">{{ $client->nom }}</h2>
                <p class="card-text">
                    <strong>Numéro de sécurité sociale :</strong> {{ $client->numero_securite_sociale }}<br>
                    <strong>Email :</strong> {{ $client->email }}<br>
                    <strong>Date de naissance :</strong> {{ $client->date_naissance }}<br>
                    <strong>Adresse :</strong> {{ $client->adresse }}<br>
                    <strong>Téléphone :</strong> {{ $client->telephone }}<br>
                    <strong>Créé le :</strong> {{ $client->created_at->format('d/m/Y à H:i') }}<br>
                </p>
            </div>
        </div>
    </main>

    <footer class="bg-primary text-white py-3">
        <div class="container text-center">
            <p class="m-0">&copy; 2025 Mutuelle Santé</p>
        </div>
    </footer>

</body>
</html>
