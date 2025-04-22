<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord | {{ auth()->user()->nom }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> {{-- Si tu utilises Laravel Mix ou Vite --}}
</head>
<body class="bg-gray-100 text-gray-900">

    <header class="bg-blue-600 text-white py-4 px-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold">Tableau de bord de {{ auth()->user()->nom }}</h1>
        <nav>
            <a href="{{ route('mutuelle.profile') }}" class="text-white hover:underline mr-4">Mon Profil</a>
            <a href="{{ route('mutuelle.logout') }}" class="text-white hover:underline">Déconnexion</a>
        </nav>
    </header>

    <main class="p-6">
        <h2 class="text-xl font-semibold mb-4">Bienvenue, {{ auth()->user()->nom }} !</h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Offre de Remboursement -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="font-semibold text-lg mb-2">Offres de Remboursement</h3>
                <p>Consulter vos offres de remboursement actuelles.</p>
                <a href="{{ route('mutuelle.offres.index') }}" class="text-blue-500 hover:underline">Voir les offres</a>
            </div>

            <!-- Demandes en attente -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="font-semibold text-lg mb-2">Demandes en attente</h3>
                <p>Vérifier les demandes de remboursement en attente.</p>
                <a href="{{ route('mutuelle.demandes.index') }}" class="text-blue-500 hover:underline">Voir les demandes</a>
            </div>

            <!-- Statistiques -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="font-semibold text-lg mb-2">Statistiques</h3>
                <p>Consulter vos statistiques de remboursement.</p>
                <a href="{{ route('mutuelle.statistiques') }}" class="text-blue-500 hover:underline">Voir les statistiques</a>
            </div>
        </div>
    </main>

</body>
</html>
