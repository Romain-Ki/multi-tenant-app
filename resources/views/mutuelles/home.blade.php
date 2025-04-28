<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord | {{ auth()->user()->nom }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="bg-light">

    <!-- Header -->
    <header class="bg-primary text-white py-4 mb-5">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h3 m-0">Tableau de bord de {{ auth()->user()->nom }}</h1>
            <nav>
                <a href="{{ route('mutuelles.edit',  auth()->user()->id) }}" class="text-white text-decoration-none me-3">Mon Profil</a>
                <a href="{{ route('mutuelle.logout') }}" class="btn btn-outline-light btn-sm">Déconnexion</a>
            </nav>
        </div>
    </header>

    <!-- Contenu principal -->
    <main class="container mb-5">
        <div class="text-center mb-4">
            <h2 class="fw-bold">Bienvenue, {{ auth()->user()->nom }} !</h2>
            <p class="text-muted">Gérez votre espace mutuelle depuis ce tableau de bord.</p>
        </div>

        <!-- Barre de recherche -->
        <div class="mb-5">
            <form id="searchForm" method="GET" action="{{ route('mutuelle.searchClientByNumeroSocial', ['numero' => 'placeholder']) }}">
                <div class="input-group">
                    <input type="text" class="form-control" id="searchInput" placeholder="Rechercher un client par numéro de sécurité sociale..." aria-label="Recherche" required>
                    <button class="btn btn-outline-primary" type="submit">Rechercher</button>
                </div>
            </form>
        </div>

        <div class="row g-4">
            <!-- Offres de remboursement -->
            <div class="col-md-4">
                <div class="card shadow-lg rounded-4 h-100">
                    <div class="card-body">
                        <h5 class="card-title">Offres de Remboursement</h5>
                        <p class="card-text">Consultez vos offres de remboursement disponibles.</p>
                        <a href="#" class="btn btn-primary">Voir les offres</a>
                    </div>
                </div>
            </div>

            <!-- Demandes en attente -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="font-semibold text-lg mb-2">Clients</h3>
                <a href="{{ route('mutuelle.clients') }}" class="text-blue-500 hover:underline">Voir les clients</a>
            </div>

            <!-- Statistiques -->
            <div class="col-md-4">
                <div class="card shadow-lg rounded-4 h-100">
                    <div class="card-body">
                        <h5 class="card-title">Statistiques</h5>
                        <p class="card-text">Visualisez vos remboursements passés en chiffres.</p>
                        <a href="#" class="btn btn-primary">Voir les statistiques</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-primary text-white py-3">
        <div class="container text-center">
            <p class="m-0">&copy; 2025 Mutuelle Santé</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('searchForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const input = document.getElementById('searchInput').value.trim();

            if (input.length > 0) {
                const route = "{{ route('mutuelle.searchClientByNumeroSocial', ['numero' => 'REPLACE_UUID']) }}";
                const redirectUrl = route.replace('REPLACE_UUID', encodeURIComponent(input));
                window.location.href = redirectUrl;
            }
        });
    </script>

</body>
</html>
