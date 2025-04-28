<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Mutuelles</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<header class="bg-primary text-white py-5 mb-5">
    <div class="container text-center">
        <h1 class="display-4">Accédez à votre espace <a class="navbar-brand" href="{{ route('mutuelle.home') }}">Mutuelles</a></h1>
    </div>
</header>
{{--<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">--}}
{{--    <div class="container">--}}
{{--        <a class="navbar-brand" href="{{ route('mutuelles') }}">Mutuelles</a>--}}
{{--        --}}
{{--    </div>--}}
{{--</nav>--}}

<div class="container">
    {{-- Affichage des messages flash --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Contenu injecté ici --}}
    @yield('content')
</div>

<!-- Bootstrap JS (optionnel, pour les composants interactifs) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
