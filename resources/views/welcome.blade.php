<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Choix de Connexion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Animate.css pour les animations -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />

    <!-- Font Awesome (optionnel pour icônes) -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />

    <style>
        body {
            background: linear-gradient(to right, #74ebd5, #ACB6E5);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            border: none;
            border-radius: 1rem;
        }
        .btn-lg {
            font-size: 1.2rem;
            padding: 1rem;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }
        .btn-lg:hover {
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-4 animate__animated animate__fadeInDown" style="width: 30rem;">
        <div class="card-body text-center">
            <h2 class="mb-4 fw-bold">Bienvenue</h2>
            <p class="mb-4 text-muted">Veuillez choisir votre mode de connexion :</p>

            <a href="{{ route('mutuelle.login') }}" class="btn btn-primary btn-lg w-100 mb-3 animate__animated animate__pulse animate__infinite">
                <i class="fas fa-building me-2"></i> Connexion Mutuelle
            </a>

            <a href="{{ route('client.login') }}" class="btn btn-success btn-lg w-100 animate__animated animate__pulse animate__infinite">
                <i class="fas fa-user me-2"></i> Connexion Client
            </a>

        </div>
    </div>
</div>

<!-- Bootstrap JS (optionnel) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
